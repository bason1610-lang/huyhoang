<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::query()->orderBy('position')->orderBy('sort_order')->paginate(30);

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.banners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'position' => ['required', 'in:'.Banner::POSITION_HERO.','.Banner::POSITION_SIDEBAR],
            'title' => ['nullable', 'string', 'max:190'],
            'link_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::query()->create([
            'position' => $data['position'],
            'title' => $data['title'] ?? null,
            'image_path' => $path,
            'link_url' => $data['link_url'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('status', 'Đã tạo banner.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $request->validate([
            'position' => ['required', 'in:'.Banner::POSITION_HERO.','.Banner::POSITION_SIDEBAR],
            'title' => ['nullable', 'string', 'max:190'],
            'link_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $path = $banner->image_path;
        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $path = $request->file('image')->store('banners', 'public');
        }

        $banner->update([
            'position' => $data['position'],
            'title' => $data['title'] ?? null,
            'image_path' => $path,
            'link_url' => $data['link_url'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('status', 'Đã cập nhật banner.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('status', 'Đã xóa banner.');
    }
}

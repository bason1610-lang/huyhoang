<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::query()->orderBy('sort_order')->paginate(30);

        return view('admin.branches.index', compact('branches'));
    }

    public function create(): View
    {
        return view('admin.branches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:190'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:64'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Branch::query()->create([
            'name' => $data['name'] ?? null,
            'address' => $data['address'],
            'phone' => $data['phone'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.branches.index')->with('status', 'Đã thêm chi nhánh.');
    }

    public function edit(Branch $branch): View
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:190'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:64'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $branch->update([
            'name' => $data['name'] ?? null,
            'address' => $data['address'],
            'phone' => $data['phone'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.branches.index')->with('status', 'Đã cập nhật chi nhánh.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->delete();

        return redirect()->route('admin.branches.index')->with('status', 'Đã xóa chi nhánh.');
    }
}

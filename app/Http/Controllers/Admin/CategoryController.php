<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->orderBy('parent_id')->orderBy('sort_order')->paginate(30);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parents = Category::query()->whereNull('parent_id')->orderBy('sort_order')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'parent_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = $data['slug'] ?? Str::slug($data['name']);
        $slug = $this->uniqueCategorySlug($slug);

        Category::query()->create([
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'slug' => $slug,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'Đã tạo danh mục.');
    }

    public function edit(Category $category): View
    {
        $parents = Category::query()
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'parent_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = $data['slug'] ?? Str::slug($data['name']);
        if ($slug !== $category->slug) {
            $slug = $this->uniqueCategorySlug($slug, $category->id);
        }

        $category->update([
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'slug' => $slug,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'Đã cập nhật danh mục.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children()->exists()) {
            return back()->withErrors(['delete' => 'Không xóa được: còn danh mục con.']);
        }
        if ($category->products()->exists()) {
            return back()->withErrors(['delete' => 'Không xóa được: còn sản phẩm.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Đã xóa danh mục.');
    }

    private function uniqueCategorySlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $i = 1;
        while (Category::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}

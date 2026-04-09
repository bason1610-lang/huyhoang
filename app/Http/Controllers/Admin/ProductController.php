<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->get('q', ''));

        $products = Product::query()
            ->with('category')
            ->when($q !== '', fn ($query) => $query->where('name', 'like', '%'.$q.'%'))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('parent_id')->orderBy('sort_order')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $slug = $data['slug'] ?? Str::slug($data['name']);
        $slug = $this->uniqueProductSlug($slug);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::query()->create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $slug,
            'sku' => $data['sku'] ?? null,
            'price' => (int) $data['price'],
            'compare_price' => isset($data['compare_price']) ? (int) $data['compare_price'] : null,
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.products.index')->with('status', 'Đã tạo sản phẩm.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('parent_id')->orderBy('sort_order')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product->id);

        $slug = $data['slug'] ?? Str::slug($data['name']);
        if ($slug !== $product->slug) {
            $slug = $this->uniqueProductSlug($slug, $product->id);
        }

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $slug,
            'sku' => $data['sku'] ?? null,
            'price' => (int) $data['price'],
            'compare_price' => isset($data['compare_price']) ? (int) $data['compare_price'] : null,
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.products.index')->with('status', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Đã xóa sản phẩm.');
    }

    private function validated(Request $request, ?int $productId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190'],
            'sku' => ['nullable', 'string', 'max:64'],
            'price' => ['required', 'integer', 'min:0'],
            'compare_price' => ['nullable', 'integer', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueProductSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $i = 1;
        while (Product::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}

<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $rootCategories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->with(['children' => fn ($q) => $q->orderBy('sort_order')])
            ->get();

        $heroBanners = Banner::query()
            ->where('position', Banner::POSITION_HERO)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $sidebarBanners = Banner::query()
            ->where('position', Banner::POSITION_SIDEBAR)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categorySections = $rootCategories->take(6)->map(function (Category $category) {
            $products = Product::query()
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->limit(8)
                ->get();

            return [
                'category' => $category,
                'products' => $products,
            ];
        })->filter(fn (array $row) => $row['products']->isNotEmpty());

        return view('store.home', [
            'rootCategories' => $rootCategories,
            'heroBanners' => $heroBanners,
            'sidebarBanners' => $sidebarBanners,
            'categorySections' => $categorySections,
        ]);
    }
}

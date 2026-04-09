<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.store', 'store.*'], function ($view) {
            $cart = session('cart', []);
            $cartQty = is_array($cart) ? (int) array_sum($cart) : 0;
            $cartTotal = 0;
            if (is_array($cart) && $cart !== []) {
                $ids = array_keys($cart);
                $products = Product::query()->whereIn('id', $ids)->get()->keyBy('id');
                foreach ($cart as $pid => $qty) {
                    $p = $products->get((int) $pid);
                    if ($p) {
                        $cartTotal += $p->price * (int) $qty;
                    }
                }
            }

            $rootCategories = Category::query()
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->with(['children' => fn ($q) => $q->orderBy('sort_order')])
                ->get()
                ->map(function ($cat) {
                    // Lấy top 6 sản phẩm nổi bật của mỗi category
                    $cat->topProducts = Product::query()
                        ->where('category_id', $cat->id)
                        ->where('is_active', true)
                        ->orderByDesc('is_featured')
                        ->orderBy('sort_order')
                        ->limit(6)
                        ->get();
                    return $cat;
                });

            $view->with([
                'rootCategories' => $rootCategories,
                'branches' => Branch::query()->orderBy('sort_order')->get(),
                'headerCartQty' => $cartQty,
                'headerCartTotal' => $cartTotal,
            ]);
        });
    }
}

<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $q = trim((string) $request->get('q', ''));

        $products = Product::query()
            ->where('is_active', true)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name', 'like', '%'.$q.'%')
                        ->orWhere('short_description', 'like', '%'.$q.'%');
                });
            })
            ->orderByDesc('is_featured')
            ->paginate(12)
            ->withQueryString();

        return view('store.search', [
            'q' => $q,
            'products' => $products,
        ]);
    }
}

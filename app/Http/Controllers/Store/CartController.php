<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private const SESSION_KEY = 'cart';

    public function index(Request $request): View
    {
        $lines = $this->resolveLines($request);
        $total = $lines->sum(fn (array $l) => $l['line_total']);

        return view('store.cart', [
            'lines' => $lines,
            'total' => $total,
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $qty = (int) ($data['quantity'] ?? 1);
        $cart = $request->session()->get(self::SESSION_KEY, []);
        $pid = (int) $data['product_id'];
        $cart[$pid] = ($cart[$pid] ?? 0) + $qty;
        $request->session()->put(self::SESSION_KEY, $cart);

        return redirect()->route('cart.index')->with('status', 'Đã thêm vào giỏ hàng.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = $request->session()->get(self::SESSION_KEY, []);
        if (! isset($cart[$productId])) {
            return redirect()->route('cart.index');
        }
        $cart[$productId] = (int) $data['quantity'];
        $request->session()->put(self::SESSION_KEY, $cart);

        return redirect()->route('cart.index')->with('status', 'Đã cập nhật giỏ hàng.');
    }

    public function remove(Request $request, int $productId): RedirectResponse
    {
        $cart = $request->session()->get(self::SESSION_KEY, []);
        unset($cart[$productId]);
        $request->session()->put(self::SESSION_KEY, $cart);

        return redirect()->route('cart.index')->with('status', 'Đã xóa sản phẩm khỏi giỏ.');
    }

    /**
     * @return \Illuminate\Support\Collection<int, array{product: \App\Models\Product, quantity: int, line_total: int}>
     */
    private function resolveLines(Request $request)
    {
        $cart = $request->session()->get(self::SESSION_KEY, []);
        if ($cart === []) {
            return collect();
        }

        $ids = array_keys($cart);
        $products = Product::query()->whereIn('id', $ids)->where('is_active', true)->get()->keyBy('id');

        return collect($cart)
            ->map(function (int $qty, int $pid) use ($products) {
                $product = $products->get($pid);
                if (! $product) {
                    return null;
                }

                return [
                    'product' => $product,
                    'quantity' => $qty,
                    'line_total' => $product->price * $qty,
                ];
            })
            ->filter()
            ->values();
    }
}

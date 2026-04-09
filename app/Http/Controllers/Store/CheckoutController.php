<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private const SESSION_KEY = 'cart';

    public function create(Request $request): View|RedirectResponse
    {
        $lines = $this->resolveLines($request);
        if ($lines->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng đang trống.']);
        }

        $total = $lines->sum(fn (array $l) => $l['line_total']);

        return view('store.checkout', [
            'lines' => $lines,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $lines = $this->resolveLines($request);
        if ($lines->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng đang trống.']);
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:190'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:190'],
            'address' => ['nullable', 'string', 'max:500'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        $subtotal = $lines->sum(fn (array $l) => $l['line_total']);
        $total = $subtotal;

        $order = DB::transaction(function () use ($data, $lines, $subtotal, $total) {
            $order = Order::query()->create([
                'order_number' => $this->makeOrderNumber(),
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'address' => $data['address'] ?? null,
                'note' => $data['note'] ?? null,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            foreach ($lines as $line) {
                /** @var Product $product */
                $product = $line['product'];
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $line['quantity'],
                    'line_total' => $line['line_total'],
                ]);
            }

            return $order;
        });

        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('checkout.thanks', $order)->with('status', 'Đặt hàng thành công.');
    }

    public function thanks(Order $order): View
    {
        $order->load('items');

        return view('store.checkout-thanks', compact('order'));
    }

    private function makeOrderNumber(): string
    {
        return 'HH'.now()->format('ymd').'-'.strtoupper(substr(uniqid(), -6));
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

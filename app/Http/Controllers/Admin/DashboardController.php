<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Post;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::query()->count(),
            'postCount' => Post::query()->count(),
            'pendingOrders' => Order::query()->where('status', 'pending')->count(),
        ]);
    }
}

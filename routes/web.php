<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CategoryController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\PageController;
use App\Http\Controllers\Store\PostController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/tim-kiem', SearchController::class)->name('search');

Route::get('/danh-muc/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
Route::patch('/gio-hang/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/thanh-toan', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/dat-hang-thanh-cong/{order}', [CheckoutController::class, 'thanks'])->name('checkout.thanks');

Route::get('/bai-viet', [PostController::class, 'index'])->name('posts.index');
Route::get('/bai-viet/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/gioi-thieu', [PageController::class, 'about'])->name('pages.about');

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('banners', BannerController::class)->except(['show']);
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::resource('branches', BranchController::class)->except(['show']);

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});

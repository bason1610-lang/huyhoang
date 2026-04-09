<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ config('company.name_short') }}</title>
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <style>
        .admin-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: 100vh; }
        .admin-nav { background: #111; color: #fff; padding: 1rem; }
        .admin-nav a { color: #fecaca; display: block; padding: 0.35rem 0; font-size: 0.9rem; }
        .admin-nav a:hover { color: #fff; }
        .admin-main { padding: 1.5rem; background: #f9fafb; }
        .admin-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        table.admin { width: 100%; background: #fff; border-collapse: collapse; font-size: 0.9rem; }
        table.admin th, table.admin td { border: 1px solid #e5e7eb; padding: 0.5rem 0.65rem; text-align: left; }
        table.admin th { background: #f3f4f6; }
        .form-row { margin-bottom: 0.75rem; }
        .form-row label { display: block; font-size: 0.85rem; margin-bottom: 0.25rem; font-weight: 600; }
        .form-row input, .form-row select, .form-row textarea { width: 100%; max-width: 480px; padding: 0.45rem; }
    </style>
</head>
<body>
<div class="admin-wrap">
    <aside class="admin-nav">
        <div style="font-weight:800;margin-bottom:1rem;">{{ config('company.name_short') }} Admin</div>
        <a href="{{ route('admin.dashboard') }}">Tổng quan</a>
        <a href="{{ route('admin.categories.index') }}">Danh mục</a>
        <a href="{{ route('admin.products.index') }}">Sản phẩm</a>
        <a href="{{ route('admin.banners.index') }}">Banner</a>
        <a href="{{ route('admin.posts.index') }}">Bài viết</a>
        <a href="{{ route('admin.branches.index') }}">Chi nhánh</a>
        <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
        <hr style="border-color:#333;margin:1rem 0;">
        <a href="{{ route('home') }}" target="_blank">Xem website</a>
        <form method="post" action="{{ route('logout') }}" style="margin-top:1rem;">
            @csrf
            <button type="submit" class="btn btn-outline" style="width:100%;">Đăng xuất</button>
        </form>
    </aside>
    <div class="admin-main">
        @if(session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="flash" style="background:#fef2f2;border-color:#fecaca;color:#991b1b;">
                <ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>

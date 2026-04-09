<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('company.name')) — {{ config('company.meta_title_suffix') }}</title>
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    @stack('head')
</head>
<body>
    <div class="topbar">
        <div class="container topbar-inner">
            <div class="topbar-addresses">
                @forelse($branches as $b)
                    <span>Địa chỉ: {{ $b->address }}</span>
                @empty
                    <span>Địa chỉ showroom đang cập nhật</span>
                @endforelse
            </div>
            <div class="topbar-links">
                <a href="{{ route('pages.about') }}">Giới thiệu</a>
                <a href="{{ route('posts.index') }}">Kiến thức ô tô</a>
            </div>
        </div>
    </div>

    <header class="header-main">
        <div class="container header-grid">
            <a href="{{ route('home') }}" class="logo-wrap" title="{{ config('company.name') }}">
                <span class="logo">Huy <span>Hoàng</span></span>
                <span class="logo-sub">Tiệm chăm sóc xe</span>
            </a>

            <form class="search-form" method="get" action="{{ route('search') }}">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Bạn cần tìm gì?" autocomplete="off">
                <button type="submit">Tìm</button>
            </form>

            <div class="header-actions">
                <div class="hotline">
                    Hotline / Zalo
                    <strong>{{ config('company.phone_display') }}</strong>
                </div>
                <a href="{{ route('cart.index') }}" class="cart-badge">
                    Giỏ hàng / <span>{{ \App\Helpers\Price::format($headerCartTotal) }}</span>
                    @if($headerCartQty > 0)
                        <small>({{ $headerCartQty }})</small>
                    @endif
                </a>
                <a href="{{ route('login') }}" class="login-link" title="Đăng nhập quản trị">🔒 Đăng nhập</a>
            </div>
        </div>
    </header>

    <main class="container">
        @if(session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="flash" style="background:#fef2f2;border-color:#fecaca;color:#991b1b;">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <h3>{{ config('company.name') }}</h3>
                @foreach($branches as $b)
                    <p>{{ $b->name ? $b->name.' — ' : '' }}{{ $b->address }}</p>
                @endforeach
                <p>Hotline / Zalo: {{ config('company.phone_display') }}</p>
                <p><a href="{{ config('company.map_url') }}" target="_blank" rel="noopener">Chỉ đường Google Maps</a></p>
            </div>
            <div>
                <h3>Hỗ trợ</h3>
                <p><a href="{{ route('posts.index') }}">Kiến thức ô tô</a></p>
                <p><a href="{{ route('pages.about') }}">Giới thiệu</a></p>
            </div>
            <div>
                <h3>Mua hàng</h3>
                <p><a href="{{ route('cart.index') }}">Giỏ hàng</a></p>
                <p><a href="{{ route('checkout.create') }}">Thanh toán</a></p>
            </div>
        </div>
        <div class="container" style="margin-top:1.5rem;font-size:0.8rem;color:#9ca3af;">
            © {{ date('Y') }} {{ config('company.name') }}
        </div>
    </footer>

    <div class="floating-contact">
        <a href="https://zalo.me/{{ config('company.phone') }}" target="_blank" rel="noopener">Zalo</a>
        <a href="tel:{{ config('company.phone') }}" style="margin-left:6px;">Gọi</a>
    </div>

    <style>
        .login-link {
            background: linear-gradient(135deg, #dc2626, #991b1c);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            white-space: nowrap;
        }
        
        .login-link:hover {
            background: linear-gradient(135deg, #b91c1c, #7f1d1d);
            transform: translateY(-1px);
        }
    </style>

    @stack('scripts')
</body>
</html>

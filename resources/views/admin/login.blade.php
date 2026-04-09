<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập quản trị</title>
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>
<body style="display:flex;min-height:100vh;align-items:center;justify-content:center;background:#111;">
    <div style="background:#fff;padding:2rem;border-radius:8px;width:min(400px,100% - 2rem);">
        <p style="margin:0 0 0.25rem;font-size:0.85rem;color:#6b7280;">{{ config('company.name') }}</p>
        <h1 style="margin-top:0;color:var(--ak-red);font-size:1.25rem;">Đăng nhập quản trị</h1>
        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif
        <form method="post" action="{{ route('login') }}">
            @csrf
            <p class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:0.5rem;">
            </p>
            <p class="form-row">
                <label>Mật khẩu</label>
                <input type="password" name="password" required style="width:100%;padding:0.5rem;">
            </p>
            <p>
                <label style="font-size:0.9rem;"><input type="checkbox" name="remember" value="1"> Ghi nhớ</label>
            </p>
            <button type="submit" class="btn btn-primary" style="width:100%;">Đăng nhập</button>
        </form>
        <p style="margin-top:1rem;font-size:0.85rem;"><a href="{{ route('home') }}">← Về cửa hàng</a></p>
    </div>
</body>
</html>

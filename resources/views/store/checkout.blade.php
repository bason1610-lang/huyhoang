@extends('layouts.store')

@section('title', 'Thanh toán')

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div>
            <h1 class="section-title" style="margin-top:0;color:var(--ak-red);">Thông tin đặt hàng</h1>

            <div style="display:grid;grid-template-columns:1fr 320px;gap:2rem;align-items:start;">
                <div>
                    <form method="post" action="{{ route('checkout.store') }}" style="background:#f9fafb;padding:1.5rem;border-radius:0.5rem;">
                        @csrf

                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#333;">
                                Họ tên <span style="color:var(--ak-red);">*</span>
                            </label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required 
                                style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:0.375rem;font-size:1rem;@error('customer_name') border-color:var(--ak-red); @enderror">
                            @error('customer_name')
                                <span style="color:var(--ak-red);font-size:0.875rem;margin-top:0.25rem;display:block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#333;">
                                Số điện thoại <span style="color:var(--ak-red);">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required 
                                style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:0.375rem;font-size:1rem;@error('phone') border-color:var(--ak-red); @enderror">
                            @error('phone')
                                <span style="color:var(--ak-red);font-size:0.875rem;margin-top:0.25rem;display:block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#333;">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:0.375rem;font-size:1rem;">
                            @error('email')
                                <span style="color:var(--ak-red);font-size:0.875rem;margin-top:0.25rem;display:block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#333;">Địa chỉ giao hàng / lắp đặt</label>
                            <textarea name="address" rows="3" 
                                style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:0.375rem;font-size:1rem;font-family:inherit;">{{ old('address') }}</textarea>
                            @error('address')
                                <span style="color:var(--ak-red);font-size:0.875rem;margin-top:0.25rem;display:block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom:1.5rem;">
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#333;">Ghi chú thêm</label>
                            <textarea name="note" rows="3" placeholder="VD: Thời gian liên hệ, yêu cầu đặc biệt..." 
                                style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:0.375rem;font-size:1rem;font-family:inherit;color:#666;">{{ old('note') }}</textarea>
                            @error('note')
                                <span style="color:var(--ak-red);font-size:0.875rem;margin-top:0.25rem;display:block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;padding:0.875rem;font-size:1.05rem;font-weight:600;">Xác nhận đặt hàng</button>

                        <p style="margin-top:1rem;font-size:0.85rem;color:#666;text-align:center;">
                            Bằng cách đặt hàng, bạn đồng ý với <a href="{{ route('pages.about') }}" style="color:var(--ak-red);">Điều khoản dịch vụ</a> của chúng tôi
                        </p>
                    </form>
                </div>

                <div style="position:sticky;top:1rem;">
                    <div style="background:white;border:1px solid #e5e7eb;border-radius:0.5rem;padding:1.25rem;">
                        <h3 style="margin:0 0 1rem;font-size:1rem;color:var(--ak-red);">Đơn hàng</h3>
                        <div style="font-size:0.9rem;color:#666;margin-bottom:1.25rem;">
                            <p style="margin:0 0 0.5rem;"><strong>{{ \App\Helpers\Price::format($total) }}</strong></p>
                            <p style="margin:0;"><a href="{{ route('cart.index') }}" style="color:var(--ak-red);text-decoration:none;">Chỉnh sửa giỏ hàng</a></p>
                        </div>
                        
                        <div style="background:#f9fafb;padding:0.75rem;border-radius:0.375rem;font-size:0.85rem;color:#666;">
                            <p style="margin:0 0 0.5rem;"><strong>📞 Liên hệ:</strong></p>
                            <p style="margin:0;color:var(--ak-red);font-weight:600;">{{ config('company.phone_display') }}</p>
                            <p style="margin:0.5rem 0 0;">Hotline / Zalo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

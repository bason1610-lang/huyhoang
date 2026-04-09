@extends('layouts.store')

@section('title', 'Đặt hàng thành công')

@section('content')
    <div style="margin-top:1.5rem;">
        <h1 class="section-title" style="margin-top:0;">Cảm ơn bạn đã đặt hàng</h1>
        <p>Mã đơn: <strong>{{ $order->order_number }}</strong></p>
        <p>Chúng tôi sẽ liên hệ xác nhận qua số điện thoại: <strong>{{ $order->phone }}</strong></p>
        <p>Hoặc liên hệ trực tiếp: <strong>{{ config('company.phone_display') }}</strong> (Hotline / Zalo)</p>
        <p><a href="{{ route('home') }}" class="btn btn-outline">Về trang chủ</a></p>
    </div>
@endsection

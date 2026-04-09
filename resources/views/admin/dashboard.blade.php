@extends('layouts.admin')

@section('title', 'Tổng quan')

@section('content')
    <div class="admin-bar">
        <h1 style="margin:0;">Tổng quan</h1>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;">
        <div class="card" style="padding:1rem;">
            <div style="font-size:0.85rem;color:#6b7280;">Sản phẩm</div>
            <div style="font-size:1.5rem;font-weight:800;">{{ $productCount }}</div>
        </div>
        <div class="card" style="padding:1rem;">
            <div style="font-size:0.85rem;color:#6b7280;">Bài viết</div>
            <div style="font-size:1.5rem;font-weight:800;">{{ $postCount }}</div>
        </div>
        <div class="card" style="padding:1rem;">
            <div style="font-size:0.85rem;color:#6b7280;">Đơn chờ xử lý</div>
            <div style="font-size:1.5rem;font-weight:800;">{{ $pendingOrders }}</div>
        </div>
    </div>
@endsection

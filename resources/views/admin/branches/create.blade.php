@extends('layouts.admin')

@section('title', 'Thêm chi nhánh')

@section('content')
    <h1>Thêm chi nhánh</h1>
    <form method="post" action="{{ route('admin.branches.store') }}">
        @csrf
        <div class="form-row">
            <label>Tên showroom</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div class="form-row">
            <label>Địa chỉ *</label>
            <input type="text" name="address" value="{{ old('address') }}" required>
        </div>
        <div class="form-row">
            <label>Điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection

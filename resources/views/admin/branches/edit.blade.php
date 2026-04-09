@extends('layouts.admin')

@section('title', 'Sửa chi nhánh')

@section('content')
    <h1>Sửa chi nhánh</h1>
    <form method="post" action="{{ route('admin.branches.update', $branch) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Tên showroom</label>
            <input type="text" name="name" value="{{ old('name', $branch->name) }}">
        </div>
        <div class="form-row">
            <label>Địa chỉ *</label>
            <input type="text" name="address" value="{{ old('address', $branch->address) }}" required>
        </div>
        <div class="form-row">
            <label>Điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $branch->sort_order) }}" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

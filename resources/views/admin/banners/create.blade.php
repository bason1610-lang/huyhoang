@extends('layouts.admin')

@section('title', 'Thêm banner')

@section('content')
    <h1>Thêm banner</h1>
    <form method="post" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <label>Vị trí *</label>
            <select name="position" required>
                <option value="hero">Slider trang chủ (hero)</option>
                <option value="sidebar">Cột phải trang chủ (sidebar)</option>
            </select>
        </div>
        <div class="form-row">
            <label>Tiêu đề</label>
            <input type="text" name="title" value="{{ old('title') }}">
        </div>
        <div class="form-row">
            <label>Link URL</label>
            <input type="url" name="link_url" value="{{ old('link_url') }}" placeholder="https://">
        </div>
        <div class="form-row">
            <label>Ảnh *</label>
            <input type="file" name="image" accept="image/*" required>
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
        </div>
        <p><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Kích hoạt</label></p>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection

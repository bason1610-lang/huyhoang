@extends('layouts.admin')

@section('title', 'Sửa banner')

@section('content')
    <h1>Sửa banner</h1>
    <form method="post" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Vị trí *</label>
            <select name="position" required>
                <option value="hero" @selected(old('position', $banner->position) === 'hero')>Slider (hero)</option>
                <option value="sidebar" @selected(old('position', $banner->position) === 'sidebar')>Sidebar</option>
            </select>
        </div>
        <div class="form-row">
            <label>Tiêu đề</label>
            <input type="text" name="title" value="{{ old('title', $banner->title) }}">
        </div>
        <div class="form-row">
            <label>Link URL</label>
            <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url) }}">
        </div>
        <div class="form-row">
            <p><img src="{{ $banner->imageUrl() }}" alt="" style="max-height:100px;"></p>
            <label>Ảnh mới (để trống nếu giữ)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
        </div>
        <p><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active))> Kích hoạt</label></p>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

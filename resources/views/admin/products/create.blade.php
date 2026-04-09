@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
    <h1>Thêm sản phẩm</h1>
    <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <label>Danh mục *</label>
            <select name="category_id" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->parent_id ? '— ' : '' }}{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label>Tên *</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}">
        </div>
        <div class="form-row">
            <label>SKU</label>
            <input type="text" name="sku" value="{{ old('sku') }}">
        </div>
        <div class="form-row">
            <label>Giá (VNĐ) *</label>
            <input type="number" name="price" value="{{ old('price') }}" min="0" required>
        </div>
        <div class="form-row">
            <label>Giá niêm yết</label>
            <input type="number" name="compare_price" value="{{ old('compare_price') }}" min="0">
        </div>
        <div class="form-row">
            <label>Mô tả ngắn</label>
            <input type="text" name="short_description" value="{{ old('short_description') }}">
        </div>
        <div class="form-row">
            <label>Mô tả chi tiết</label>
            <textarea name="description" rows="6">{{ old('description') }}</textarea>
        </div>
        <div class="form-row">
            <label>Ảnh</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
        </div>
        <p><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Hiển thị</label></p>
        <p><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured'))> Nổi bật</label></p>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection

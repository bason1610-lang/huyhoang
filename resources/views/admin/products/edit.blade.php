@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
    <h1>Sửa sản phẩm</h1>
    <form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Danh mục *</label>
            <select name="category_id" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->parent_id ? '— ' : '' }}{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label>Tên *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}">
        </div>
        <div class="form-row">
            <label>SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}">
        </div>
        <div class="form-row">
            <label>Giá (VNĐ) *</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required>
        </div>
        <div class="form-row">
            <label>Giá niêm yết</label>
            <input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" min="0">
        </div>
        <div class="form-row">
            <label>Mô tả ngắn</label>
            <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}">
        </div>
        <div class="form-row">
            <label>Mô tả chi tiết</label>
            <textarea name="description" rows="6">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="form-row">
            <p>Ảnh hiện tại: @if($product->image_path)<img src="{{ $product->imageUrl() }}" alt="" style="max-height:80px;">@else — @endif</p>
            <label>Ảnh mới</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" min="0">
        </div>
        <p><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))> Hiển thị</label></p>
        <p><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> Nổi bật</label></p>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

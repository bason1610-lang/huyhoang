@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')
    <h1>Sửa danh mục</h1>
    <form method="post" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Danh mục cha</label>
            <select name="parent_id">
                <option value="">— Không —</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}" @selected(old('parent_id', $category->parent_id) == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label>Tên *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.categories.index') }}">Hủy</a>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
    <h1>Thêm danh mục</h1>
    <form method="post" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="form-row">
            <label>Danh mục cha</label>
            <select name="parent_id">
                <option value="">— Không —</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label>Tên *</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-row">
            <label>Slug (để trống để tự sinh)</label>
            <input type="text" name="slug" value="{{ old('slug') }}">
        </div>
        <div class="form-row">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.categories.index') }}">Hủy</a>
    </form>
@endsection

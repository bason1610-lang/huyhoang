@extends('layouts.admin')

@section('title', 'Thêm bài viết')

@section('content')
    <h1>Thêm bài viết</h1>
    <form method="post" action="{{ route('admin.posts.store') }}">
        @csrf
        <div class="form-row">
            <label>Tiêu đề *</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}">
        </div>
        <div class="form-row">
            <label>Tóm tắt</label>
            <input type="text" name="excerpt" value="{{ old('excerpt') }}">
        </div>
        <div class="form-row">
            <label>Nội dung *</label>
            <textarea name="body" rows="12" required>{{ old('body') }}</textarea>
        </div>
        <div class="form-row">
            <label>Ngày xuất bản</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at') }}">
        </div>
        <p><label><input type="checkbox" name="is_published" value="1" @checked(old('is_published'))> Xuất bản</label></p>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection

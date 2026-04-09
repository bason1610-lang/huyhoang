@extends('layouts.admin')

@section('title', 'Sửa bài viết')

@section('content')
    <h1>Sửa bài viết</h1>
    <form method="post" action="{{ route('admin.posts.update', $post) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Tiêu đề *</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}">
        </div>
        <div class="form-row">
            <label>Tóm tắt</label>
            <input type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}">
        </div>
        <div class="form-row">
            <label>Nội dung *</label>
            <textarea name="body" rows="12" required>{{ old('body', $post->body) }}</textarea>
        </div>
        <div class="form-row">
            <label>Ngày xuất bản</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
        </div>
        <p><label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published))> Xuất bản</label></p>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'Bài viết')

@section('content')
    <div class="admin-bar">
        <h1 style="margin:0;">Bài viết</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Thêm</a>
    </div>
    <table class="admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Xuất bản</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->is_published ? 'Có' : 'Không' }}</td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $post) }}">Sửa</a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="post" style="display:inline;" onsubmit="return confirm('Xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b91c1c;cursor:pointer;padding:0;">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $posts->links() }}</div>
@endsection

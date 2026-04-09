@extends('layouts.admin')

@section('title', 'Banner')

@section('content')
    <div class="admin-bar">
        <h1 style="margin:0;">Banner</h1>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm</a>
    </div>
    <table class="admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vị trí</th>
                <th>Tiêu đề</th>
                <th>Hoạt động</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->position }}</td>
                    <td>{{ $b->title ?? '—' }}</td>
                    <td>{{ $b->is_active ? 'Có' : 'Không' }}</td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $b) }}">Sửa</a>
                        <form action="{{ route('admin.banners.destroy', $b) }}" method="post" style="display:inline;" onsubmit="return confirm('Xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b91c1c;cursor:pointer;padding:0;">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $banners->links() }}</div>
@endsection

@extends('layouts.admin')

@section('title', 'Danh mục')

@section('content')
    <div class="admin-bar">
        <h1 style="margin:0;">Danh mục</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm</a>
    </div>
    @if($errors->has('delete'))
        <p class="error">{{ $errors->first('delete') }}</p>
    @endif
    <table class="admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Cha</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->slug }}</td>
                    <td>{{ $c->parent_id ? '#' . $c->parent_id : '—' }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $c) }}">Sửa</a>
                        <form action="{{ route('admin.categories.destroy', $c) }}" method="post" style="display:inline;" onsubmit="return confirm('Xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b91c1c;cursor:pointer;padding:0;">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $categories->links() }}</div>
@endsection

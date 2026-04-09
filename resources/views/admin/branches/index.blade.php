@extends('layouts.admin')

@section('title', 'Chi nhánh')

@section('content')
    <div class="admin-bar">
        <h1 style="margin:0;">Chi nhánh</h1>
        <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">Thêm</a>
    </div>
    <table class="admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Địa chỉ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->name ?? '—' }}</td>
                    <td>{{ $b->address }}</td>
                    <td>
                        <a href="{{ route('admin.branches.edit', $b) }}">Sửa</a>
                        <form action="{{ route('admin.branches.destroy', $b) }}" method="post" style="display:inline;" onsubmit="return confirm('Xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b91c1c;cursor:pointer;padding:0;">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $branches->links() }}</div>
@endsection

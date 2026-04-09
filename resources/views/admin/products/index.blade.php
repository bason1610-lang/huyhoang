@extends('layouts.admin')

@section('title', 'Sản phẩm')

@section('content')
    <div class="admin-bar">
        <h1 style="margin:0;">Sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Thêm</a>
    </div>
    <form method="get" style="margin-bottom:1rem;">
        <input type="search" name="q" value="{{ $q }}" placeholder="Tìm tên..." style="padding:0.45rem;width:240px;">
        <button type="submit" class="btn btn-outline">Lọc</button>
    </form>
    <table class="admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Hiện</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name ?? '—' }}</td>
                    <td>{{ \App\Helpers\Price::format($p->price) }}</td>
                    <td>{{ $p->is_active ? 'Có' : 'Không' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $p) }}">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $p) }}" method="post" style="display:inline;" onsubmit="return confirm('Xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b91c1c;cursor:pointer;padding:0;">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $products->links() }}</div>
@endsection

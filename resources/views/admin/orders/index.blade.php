@extends('layouts.admin')

@section('title', 'Đơn hàng')

@section('content')
    <h1>Đơn hàng</h1>
    <form method="get" style="margin-bottom:1rem;">
        <select name="status" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" @selected($status === 'pending')>Chờ xử lý</option>
            <option value="processing" @selected($status === 'processing')>Đang xử lý</option>
            <option value="completed" @selected($status === 'completed')>Hoàn thành</option>
            <option value="cancelled" @selected($status === 'cancelled')>Đã hủy</option>
        </select>
    </form>
    <table class="admin">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách</th>
                <th>SĐT</th>
                <th>Tổng</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
                <tr>
                    <td>{{ $o->order_number }}</td>
                    <td>{{ $o->customer_name }}</td>
                    <td>{{ $o->phone }}</td>
                    <td>{{ \App\Helpers\Price::format($o->total) }}</td>
                    <td>{{ $o->status }}</td>
                    <td><a href="{{ route('admin.orders.show', $o) }}">Chi tiết</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $orders->links() }}</div>
@endsection

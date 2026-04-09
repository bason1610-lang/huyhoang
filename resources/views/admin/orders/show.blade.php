@extends('layouts.admin')

@section('title', 'Đơn '.$order->order_number)

@section('content')
    <h1>Đơn {{ $order->order_number }}</h1>
    <p><strong>Khách:</strong> {{ $order->customer_name }} — {{ $order->phone }}</p>
    @if($order->email)<p><strong>Email:</strong> {{ $order->email }}</p>@endif
    @if($order->address)<p><strong>Địa chỉ:</strong> {{ $order->address }}</p>@endif
    @if($order->note)<p><strong>Ghi chú:</strong> {{ $order->note }}</p>@endif
    <p><strong>Tổng:</strong> {{ \App\Helpers\Price::format($order->total) }}</p>

    <form method="post" action="{{ route('admin.orders.update-status', $order) }}" style="margin:1rem 0;">
        @csrf
        @method('PATCH')
        <label>Trạng thái
            <select name="status">
                <option value="pending" @selected($order->status === 'pending')>pending</option>
                <option value="processing" @selected($order->status === 'processing')>processing</option>
                <option value="completed" @selected($order->status === 'completed')>completed</option>
                <option value="cancelled" @selected($order->status === 'cancelled')>cancelled</option>
            </select>
        </label>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>

    <h2>Chi tiết</h2>
    <table class="admin">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>SL</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ \App\Helpers\Price::format($item->unit_price) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ \App\Helpers\Price::format($item->line_total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><a href="{{ route('admin.orders.index') }}">← Danh sách đơn</a></p>
@endsection

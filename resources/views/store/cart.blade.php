@extends('layouts.store')

@section('title', 'Giỏ hàng')

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div>
            <h1 class="section-title" style="margin-top:0;">🛒 Giỏ hàng của bạn</h1>

            @if($lines->isEmpty())
                <div style="padding:2rem;background:#f0fdf4;border:2px dashed #86efac;border-radius:0.5rem;text-align:center;">
                    <p style="font-size:1.1rem;color:#333;margin-bottom:1rem;">Giỏ hàng của bạn đang trống</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">← Tiếp tục mua sắm</a>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;margin-bottom:1.5rem;">
                        <thead style="background:#f3f4f6;border-bottom:2px solid #ddd;">
                            <tr>
                                <th style="padding:0.75rem;text-align:left;font-weight:600;">Sản phẩm</th>
                                <th style="padding:0.75rem;text-align:center;font-weight:600;">Đơn giá</th>
                                <th style="padding:0.75rem;text-align:center;font-weight:600;">Số lượng</th>
                                <th style="padding:0.75rem;text-align:right;font-weight:600;">Thành tiền</th>
                                <th style="padding:0.75rem;text-align:center;font-weight:600;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lines as $line)
                                @php($p = $line['product'])
                                <tr style="border-bottom:1px solid #e5e7eb;">
                                    <td style="padding:1rem 0.75rem;">
                                        <a href="{{ route('product.show', $p->slug) }}" style="color:var(--ak-red);text-decoration:none;font-weight:500;">{{ $p->name }}</a>
                                    </td>
                                    <td style="padding:0.75rem;text-align:center;">{{ \App\Helpers\Price::format($p->price) }}</td>
                                    <td style="padding:0.75rem;text-align:center;">
                                        <form method="post" action="{{ route('cart.update', $p->id) }}" style="display:flex;gap:0.35rem;align-items:center;justify-content:center;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $line['quantity'] }}" min="1" max="99" style="width:3.5rem;padding:0.35rem;border:1px solid #ddd;border-radius:0.25rem;text-align:center;">
                                            <button type="submit" class="btn btn-outline" style="padding:0.25rem 0.5rem;font-size:0.85rem;">Cập nhật</button>
                                        </form>
                                    </td>
                                    <td style="padding:0.75rem;text-align:right;font-weight:600;color:var(--ak-red);">{{ \App\Helpers\Price::format($line['line_total']) }}</td>
                                    <td style="padding:0.75rem;text-align:center;">
                                        <form method="post" action="{{ route('cart.remove', $p->id) }}" onsubmit="return confirm('Xóa sản phẩm này?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline" style="color:#b91c1c;padding:0.25rem 0.5rem;font-size:0.85rem;">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="display:grid;grid-template-columns:1fr auto;gap:2rem;align-items:start;">
                    <div>
                        <a href="{{ route('home') }}" class="btn btn-outline" style="display:inline-block;">← Tiếp tục mua sắm</a>
                    </div>
                    <div style="background:#f9fafb;padding:1.5rem;border-radius:0.5rem;border:1px solid #e5e7eb;text-align:right;">
                        <div style="margin-bottom:1rem;">
                            <strong style="display:block;color:#666;font-size:0.9rem;">Tạm tính</strong>
                            <div style="font-size:1.5rem;color:var(--ak-red);font-weight:700;">{{ \App\Helpers\Price::format($total) }}</div>
                        </div>
                        <a href="{{ route('checkout.create') }}" class="btn btn-primary" style="display:inline-block;min-width:200px;">Tiến hành đặt hàng →</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

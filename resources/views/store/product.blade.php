@extends('layouts.store')

@section('title', $product->name)

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                › <a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                › {{ $product->name }}
            </nav>

            <div style="display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.1fr);gap:1.5rem;">
                <div class="card" style="padding:0;overflow:hidden;">
                    <div class="card-img" style="aspect-ratio:1/1;">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                </div>
                <div>
                    <h1 style="margin-top:0;font-size:1.4rem;color:var(--ak-red);">{{ $product->name }}</h1>
                    
                    @if($product->sku)
                        <p style="color:#666;font-size:0.9rem;margin-bottom:0.5rem;">SKU: {{ $product->sku }}</p>
                    @endif

                    <div style="background:#f3f4f6;padding:1rem;border-radius:0.5rem;margin-bottom:1rem;">
                        <div style="font-size:1.4rem;color:var(--ak-red);font-weight:700;">{{ \App\Helpers\Price::format($product->price) }}</div>
                        @if($product->compare_price)
                            <div style="font-size:0.9rem;color:#999;text-decoration:line-through;margin-top:0.25rem;">
                                {{ \App\Helpers\Price::format($product->compare_price) }}
                            </div>
                        @endif
                    </div>

                    @if($product->short_description)
                        <p style="color:#555;line-height:1.6;">{{ $product->short_description }}</p>
                    @endif

                    <form method="post" action="{{ route('cart.add') }}" style="margin-top:1.5rem;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div style="display:flex;gap:0.75rem;align-items:center;margin-bottom:1rem;">
                            <label style="font-weight:600;">Số lượng:</label>
                            <input type="number" name="quantity" value="1" min="1" max="99" style="width:4.5rem;padding:0.5rem;border:1px solid #ddd;border-radius:0.25rem;text-align:center;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="min-height:2.75rem;">Thêm vào giỏ hàng</button>
                    </form>

                    <p style="margin-top:1rem;">
                        <a href="{{ route('cart.index') }}" style="color:var(--ak-red);text-decoration:underline;">Xem giỏ hàng</a>
                    </p>
                </div>
            </div>

            @if($product->description)
                <div class="prose" style="margin-top:2rem;padding:1rem;background:#f9fafb;border-left:4px solid var(--ak-red);border-radius:0.25rem;">
                    <h3 style="margin-top:0;color:var(--ak-red);">Mô tả chi tiết</h3>
                    {!! nl2br(e($product->description)) !!}
                </div>
            @endif

            @if($related->isNotEmpty())
                <h2 class="section-title" style="margin-top:2rem;">Sản phẩm cùng danh mục</h2>
                <div class="product-grid">
                    @foreach($related as $p)
                        <article class="card" style="transition:transform 0.2s,box-shadow 0.2s;">
                            <a href="{{ route('product.show', $p->slug) }}" class="card-img">
                                <img src="{{ $p->imageUrl() }}" alt="{{ $p->name }}" style="width:100%;height:100%;object-fit:cover;">
                            </a>
                            <div class="card-body">
                                <h3 class="card-title" style="font-size:0.95rem;"><a href="{{ route('product.show', $p->slug) }}">{{ $p->name }}</a></h3>
                                <div style="font-weight:700;color:var(--ak-red);margin-top:0.5rem;">{{ \App\Helpers\Price::format($p->price) }}</div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

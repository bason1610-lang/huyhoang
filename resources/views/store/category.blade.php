@extends('layouts.store')

@section('title', $category->name)

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                › {{ $category->name }}
            </nav>
            <h1 class="section-title" style="margin-top:0;">{{ $category->name }}</h1>

            <div class="product-grid">
                @forelse($products as $product)
                    <article class="card">
                        <a href="{{ route('product.show', $product->slug) }}" class="card-img">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h2>
                            <div>
                                <span class="price">{{ \App\Helpers\Price::format($product->price) }}</span>
                                @if($product->compare_price)
                                    <span class="price-old">{{ \App\Helpers\Price::format($product->compare_price) }}</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <p>Chưa có sản phẩm trong danh mục này.</p>
                @endforelse
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

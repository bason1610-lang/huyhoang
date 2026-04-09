@extends('layouts.store')

@section('title', 'Tìm kiếm')

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div>
            <h1 class="section-title" style="margin-top:0;">Kết quả tìm kiếm @if($q !== '')“{{ $q }}”@endif</h1>

            <div class="product-grid">
                @forelse($products as $product)
                    <article class="card">
                        <a href="{{ route('product.show', $product->slug) }}" class="card-img">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body">
                            <h2 class="card-title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h2>
                            <div class="price">{{ \App\Helpers\Price::format($product->price) }}</div>
                        </div>
                    </article>
                @empty
                    <p>Không tìm thấy sản phẩm phù hợp.</p>
                @endforelse
            </div>

            <div class="pagination">{{ $products->links() }}</div>
        </div>
    </div>
@endsection

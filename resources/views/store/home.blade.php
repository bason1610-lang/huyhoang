@extends('layouts.store')

@section('title', 'Trang chủ')

@section('content')
    <div class="home-grid">
        @include('store.partials.sidebar')

        <div>
            @if($heroBanners->isEmpty())
                <div class="hero-slider">
                    <div class="hero-slide active">
                        <img src="{{ asset('images/placeholder-banner.svg') }}" alt="Banner">
                    </div>
                </div>
            @else
                <div class="hero-slider" id="hero-slider">
                    @foreach($heroBanners as $i => $banner)
                        <div class="hero-slide {{ $i === 0 ? 'active' : '' }}">
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}">
                                    <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title ?? 'Banner' }}">
                                </a>
                            @else
                                <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title ?? 'Banner' }}">
                            @endif
                        </div>
                    @endforeach
                    <div class="hero-dots" id="hero-dots"></div>
                </div>
            @endif
        </div>

        <div class="side-banners">
            @forelse($sidebarBanners as $banner)
                <a href="{{ $banner->link_url ?? '#' }}">
                    <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title ?? 'Khuyến mãi' }}">
                </a>
            @empty
                <img src="{{ asset('images/placeholder-banner.svg') }}" alt="">
                <img src="{{ asset('images/placeholder-banner.svg') }}" alt="">
            @endforelse
        </div>
    </div>

    <section class="intro-block">
        <h1>{{ config('company.headline') }}</h1>
        <p style="font-size:1.05rem;margin-bottom:0.5rem;">✨ {{ config('company.lead') }}</p>
        <p><strong>{{ config('company.name') }}</strong> — chăm sóc, làm đẹp và nâng cấp xe tại Dĩ An: rửa xe chi tiết, vệ sinh nội thất & khoang máy, phủ ceramic, camera — camera 360, màn hình Android, phụ kiện theo yêu cầu. <a href="{{ route('pages.about') }}">Xem giới thiệu đầy đủ</a></p>
    </section>

    @foreach($categorySections as $section)
        <h2 class="section-title">{{ $section['category']->name }}</h2>
        <div class="product-grid">
            @foreach($section['products'] as $product)
                <article class="card">
                    <a href="{{ route('product.show', $product->slug) }}" class="card-img">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div>
                            <span class="price">{{ \App\Helpers\Price::format($product->price) }}</span>
                            @if($product->compare_price)
                                <span class="price-old">{{ \App\Helpers\Price::format($product->compare_price) }}</span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <p style="margin-top:0.75rem;">
            <a href="{{ route('category.show', $section['category']->slug) }}" class="btn btn-outline">Xem tất cả</a>
        </p>
    @endforeach
@endsection

@push('scripts')
@if($heroBanners->count() > 1)
<script>
(function(){
  const slides = document.querySelectorAll('#hero-slider .hero-slide');
  const dotsWrap = document.getElementById('hero-dots');
  if (!slides.length || !dotsWrap) return;
  let i = 0;
  slides.forEach((_, idx) => {
    const b = document.createElement('button');
    b.type = 'button';
    if (idx === 0) b.classList.add('active');
    b.addEventListener('click', () => go(idx));
    dotsWrap.appendChild(b);
  });
  const dotEls = () => dotsWrap.querySelectorAll('button');
  function go(n){
    slides[i].classList.remove('active');
    dotEls()[i].classList.remove('active');
    i = (n + slides.length) % slides.length;
    slides[i].classList.add('active');
    dotEls()[i].classList.add('active');
  }
  setInterval(() => go(i+1), 5000);
})();
</script>
@endif
@endpush

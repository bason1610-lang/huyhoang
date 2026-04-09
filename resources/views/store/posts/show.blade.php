@extends('layouts.store')

@section('title', $post->title)

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <article class="prose">
            <nav class="breadcrumb">
                <a href="{{ route('posts.index') }}">📚 Kiến thức ô tô</a> › {{ $post->title }}
            </nav>
            
            <h1 style="color:var(--ak-red);margin-top:1rem;margin-bottom:0.5rem;">{{ $post->title }}</h1>
            <p style="color:#9ca3af;font-size:0.9rem;margin:0.5rem 0 1.5rem;">
                📅 {{ optional($post->published_at)->format('d/m/Y H:i') }}
            </p>

            <div style="padding:1.5rem;background:#f0fdf4;border-left:4px solid #86efac;border-radius:0.25rem;margin-bottom:1.5rem;">
                {!! nl2br(e($post->body)) !!}
            </div>

            <div style="padding:1rem;background:#f3f4f6;border-radius:0.5rem;margin-top:2rem;text-align:center;">
                <p style="margin:0 0 1rem;color:#666;">Cần hỗ trợ? Liên hệ ngay với chúng tôi!</p>
                <a href="tel:{{ config('company.phone') }}" class="btn btn-primary" style="display:inline-block;margin-right:0.5rem;">📞 Gọi ngay</a>
                <a href="https://zalo.me/{{ config('company.phone') }}" target="_blank" rel="noopener" class="btn btn-outline" style="display:inline-block;">💬 Zalo</a>
            </div>

            <p style="margin-top:2rem;text-align:center;">
                <a href="{{ route('posts.index') }}" style="color:var(--ak-red);text-decoration:none;">← Quay lại danh sách bài viết</a>
            </p>
        </article>
    </div>
@endsection

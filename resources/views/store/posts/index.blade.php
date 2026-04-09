@extends('layouts.store')

@section('title', 'Kiến thức ô tô')

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div>
            <h1 class="section-title" style="margin-top:0;color:var(--ak-red);">📚 Kiến thức ô tô</h1>
            <p style="color:#666;margin-bottom:1.5rem;">Các bài viết hữu ích về chăm sóc, bảo dưỡng và nâng cấp xe</p>
            
            @forelse($posts as $post)
                <article style="border-bottom:1px solid #e5e7eb;padding:1.5rem 0;transition:opacity 0.2s;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;">
                        <div style="flex:1;">
                            <h2 style="margin:0 0 0.5rem;font-size:1.15rem;">
                                <a href="{{ route('posts.show', $post->slug) }}" style="color:var(--ak-red);text-decoration:none;">{{ $post->title }}</a>
                            </h2>
                            <div style="font-size:0.85rem;color:#9ca3af;margin-bottom:0.75rem;">
                                📅 {{ optional($post->published_at)->format('d/m/Y') }}
                            </div>
                            @if($post->excerpt)
                                <p style="margin:0;color:#555;line-height:1.6;">{{ $post->excerpt }}</p>
                            @endif
                            <a href="{{ route('posts.show', $post->slug) }}" style="display:inline-block;margin-top:0.75rem;color:var(--ak-red);text-decoration:none;font-weight:500;">Đọc tiếp →</a>
                        </div>
                    </div>
                </article>
            @empty
                <div style="padding:2rem;background:#f3f4f6;border-radius:0.5rem;text-align:center;color:#666;">
                    <p>Chưa có bài viết nào.</p>
                </div>
            @endforelse

            <div style="margin-top:2rem;">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection

@extends('layouts.store')

@section('title', $title)

@section('content')
    <div style="display:grid;grid-template-columns:240px 1fr;gap:1rem;margin-top:1rem;align-items:start;">
        @include('store.partials.sidebar')
        <div class="prose" style="max-width:900px;">
            <h1 class="section-title" style="margin-top:0;color:var(--ak-red);">{{ config('company.name') }}</h1>
            <p style="font-size:1.15rem;font-weight:700;color:var(--ak-red);margin-bottom:0.5rem;">{{ config('company.headline') }}</p>
            <p style="font-size:1.05rem;margin-top:0.5rem;color:#555;">✨ {{ config('company.lead') }}</p>

            @foreach(config('company.sections') as $block)
                <section style="margin-top:2rem;padding:1.5rem;background:#f9fafb;border-left:4px solid var(--ak-red);border-radius:0.5rem;">
                    <h2 style="margin-top:0;color:var(--ak-red);display:flex;align-items:center;gap:0.5rem;">{{ $block['title'] }}</h2>
                    <ul style="margin:1rem 0;padding-left:1.5rem;">
                        @foreach($block['items'] as $line)
                            <li style="margin-bottom:0.5rem;color:#333;">{{ $line }}</li>
                        @endforeach
                    </ul>
                </section>
            @endforeach

            <section style="margin-top:2rem;padding:1.5rem;background:#fff3f4;border-left:4px solid var(--ak-red);border-radius:0.5rem;">
                <h2 style="margin-top:0;color:var(--ak-red);display:flex;align-items:center;gap:0.5rem;">{{ config('company.commitments.title') }}</h2>
                <ul style="margin:1rem 0;padding-left:1.5rem;columns:2;column-gap:2rem;">
                    @foreach(config('company.commitments.items') as $line)
                        <li style="margin-bottom:0.75rem;color:#333;break-inside:avoid;">{{ $line }}</li>
                    @endforeach
                </ul>
            </section>

            <section style="margin-top:2.5rem;padding:2rem;background:#f0fdf4;border-radius:0.5rem;border:2px solid #86efac;">
                <h2 style="margin-top:0;color:#16a34a;font-size:1.3rem;">📍 Liên hệ & Địa chỉ</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-top:1.5rem;">
                    <div>
                        <p style="margin-bottom:0.5rem;"><strong>Địa chỉ:</strong></p>
                        <p style="background:white;padding:1rem;border-radius:0.375rem;margin:0;color:#333;">{{ config('company.address') }}</p>
                    </div>
                    <div>
                        <p style="margin-bottom:0.5rem;"><strong>Hotline / Zalo:</strong></p>
                        <p style="background:white;padding:1rem;border-radius:0.375rem;margin:0;color:var(--ak-red);font-weight:700;font-size:1.1rem;">{{ config('company.phone_display') }}</p>
                    </div>
                </div>
                <p style="margin-top:1.5rem;text-align:center;">
                    <a href="{{ config('company.map_url') }}" target="_blank" rel="noopener" class="btn btn-primary">🗺 Mở Google Maps</a>
                </p>
            </section>
        </div>
    </div>
@endsection

@extends('landing.layouts.app')
@section('title', 'Features')

@push('styles')
<style>
    .lp-feature-card { border-radius: 20px; border: 1px solid var(--border); padding: 26px; height: 100%; transition: transform .2s ease, box-shadow .2s ease; }
    .lp-feature-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -26px rgba(15,23,42,.35); }
    .lp-feature-icon { width: 52px; height: 52px; border-radius: 14px; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 16px; }
    .lp-feature-title { font-weight: 800; font-size: 1.1rem; margin-bottom: 6px; }
</style>
@endpush

@section('content')

<section class="lp-section-tight">
    <div class="container-xl text-center">
        <h1 class="lp-h1">Everything you need to <span class="accent">grow your store</span></h1>
        <p class="lp-lead mx-auto">FlyerAll brings text message marketing, a loyalty points program, and your own branded app together in one simple in-store tablet.</p>
    </div>
</section>

<section class="lp-section">
    <div class="container-xl">
        <div class="row g-4">
            @foreach($heroHighlights->merge($footerHighlights) as $highlight)
            <div class="col-md-4 col-6">
                <div class="lp-feature-card">
                    <div class="lp-feature-icon lp-bg-{{ $highlight->color }}"><i class="bi {{ $highlight->icon }}"></i></div>
                    <div class="lp-feature-title">{{ $highlight->title }}</div>
                    <div class="text-muted small">{{ $highlight->description ?: 'Built right into every FlyerAll plan.' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="lp-section-tight">
    <div class="container-xl text-center">
        <a href="{{ route('landing.plans') }}" class="lp-btn-cta">See Pricing Plans <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

@endsection

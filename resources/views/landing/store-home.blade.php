@extends('landing.layouts.app')
@section('title', $store->name)

@push('styles')
<style>
    .lp-hero-img { width: 100%; max-width: 440px; border-radius: 20px; }
    .lp-hero-placeholder { width: 100%; aspect-ratio: 4/3; border-radius: 20px; background: linear-gradient(135deg, var(--bg-soft), #eef2ff); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 3rem; }

    .lp-step { border-radius: 22px; padding: 28px; margin-bottom: 18px; }
    .lp-step-num { width: 44px; height: 44px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; }
    .lp-step-title { font-size: 1.3rem; font-weight: 800; margin: 2px 0 8px; }
    .lp-step-desc { color: var(--muted); font-size: .95rem; line-height: 1.6; }
    .lp-step-img { width: 100%; border-radius: 16px; }
    .lp-step-img-placeholder { width: 100%; aspect-ratio: 3/4; border-radius: 16px; background: rgba(255,255,255,.5); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 2rem; }
</style>
@endpush

@section('content')

@php $stepColors = ['primary', 'purple', 'orange', 'success', 'warning', 'danger']; @endphp

<section class="lp-section">
    <div class="container-xl">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="lp-h1">
                    @if($store->hero_title)
                        {{ $store->hero_title }}
                    @else
                        Welcome to <span class="accent">{{ $store->name }}</span>
                    @endif
                </h1>
                <p class="lp-lead">{{ $store->hero_subtitle }}</p>
                <a href="{{ route('store-site.contact') }}" class="lp-btn-cta mt-2">Contact Us <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-lg-6 text-center">
                @if($store->hero_image)
                    <img src="{{ asset($store->hero_image) }}" alt="{{ $store->name }}" class="lp-hero-img">
                @elseif($store->photo)
                    <img src="{{ asset($store->photo) }}" alt="{{ $store->name }}" class="lp-hero-img">
                @else
                    <div class="lp-hero-placeholder"><i class="bi bi-shop"></i></div>
                @endif
            </div>
        </div>
    </div>
</section>

@if($steps->isNotEmpty())
<section class="lp-section" id="how-it-works">
    <div class="container-xl">
        <div class="text-center mb-5">
            <h2 class="fw-800" style="font-size:2rem;font-weight:800;">How It Works</h2>
        </div>

        @foreach($steps as $step)
        <div class="lp-step lp-soft-{{ $stepColors[$loop->index % count($stepColors)] }}">
            <div class="row align-items-center g-4">
                <div class="col-md-7 {{ $loop->even ? 'order-md-2' : '' }}">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="lp-step-num lp-bg-{{ $stepColors[$loop->index % count($stepColors)] }}">{{ $loop->iteration }}</span>
                        <h3 class="lp-step-title mb-0">{{ $step->title }}</h3>
                    </div>
                    <p class="lp-step-desc">{{ $step->description }}</p>
                </div>
                <div class="col-md-5 {{ $loop->even ? 'order-md-1' : '' }}">
                    @if($step->image)
                        <img src="{{ asset($step->image) }}" alt="{{ $step->title }}" class="lp-step-img">
                    @else
                        <div class="lp-step-img-placeholder"><i class="bi bi-image"></i></div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@if($store->socials->isNotEmpty())
<section class="lp-section-tight">
    <div class="container-xl">
        <h2 class="text-center mb-4" style="font-size:1.6rem;font-weight:800;">Follow Us</h2>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @foreach($store->socials as $social)
                <a href="{{ $social->link }}" target="_blank" rel="noopener" class="lp-contact-card" style="text-decoration:none;color:var(--ink);">
                    <span class="lp-contact-icon">
                        <img src="{{ asset($social->photo) }}" alt="{{ $social->name }}" style="width:100%;height:100%;object-fit:cover;">
                    </span>
                    <span class="fw-semibold">{{ $social->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

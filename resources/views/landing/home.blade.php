@extends('landing.layouts.app')
@section('title', 'Home')

@push('styles')
<style>
    .lp-hero-badges { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 22px; }
    .lp-hero-badge { display: flex; align-items: center; gap: 8px; background: var(--bg-soft); border: 1px solid var(--border); border-radius: 999px; padding: 8px 14px 8px 8px; font-size: .82rem; font-weight: 600; }
    .lp-hero-badge .icon { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: .85rem; flex-shrink: 0; }

    .lp-hero-img { width: 100%; max-width: 440px; border-radius: 20px; }
    .lp-hero-placeholder { width: 100%; aspect-ratio: 4/3; border-radius: 20px; background: linear-gradient(135deg, var(--bg-soft), #eef2ff); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 3rem; }

    .lp-step { border-radius: 22px; padding: 28px; margin-bottom: 18px; }
    .lp-step-num { width: 44px; height: 44px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; }
    .lp-step-title { font-size: 1.3rem; font-weight: 800; margin: 2px 0 8px; }
    .lp-step-desc { color: var(--muted); font-size: .95rem; line-height: 1.6; }
    .lp-step-checklist { list-style: none; margin: 14px 0 0; padding: 0; }
    .lp-step-checklist li { display: flex; gap: 8px; align-items: flex-start; font-weight: 600; font-size: .9rem; margin-bottom: 8px; }
    .lp-step-img { width: 100%; border-radius: 16px; }
    .lp-step-img-placeholder { width: 100%; aspect-ratio: 3/4; border-radius: 16px; background: rgba(255,255,255,.5); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 2rem; }

    .lp-banner { background: var(--c-danger); color: #fff; border-radius: 16px; padding: 16px 22px; font-weight: 700; text-align: center; }
</style>
@endpush

@section('content')

<section class="lp-section">
    <div class="container-xl">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="lp-h1">
                    @if($setting->hero_title)
                        {!! str_ireplace('FlyerAll', '<span class="accent">FlyerAll</span>', e($setting->hero_title)) !!}
                    @else
                        Grow Your Store with <span class="accent">FlyerAll</span>
                    @endif
                </h1>
                <p class="lp-lead">{{ $setting->hero_subtitle }}</p>

                @if($heroHighlights->isNotEmpty())
                <div class="lp-hero-badges">
                    @foreach($heroHighlights as $highlight)
                    <div class="lp-hero-badge">
                        <span class="icon lp-bg-{{ $highlight->color }}"><i class="bi {{ $highlight->icon }}"></i></span>
                        {{ $highlight->title }}
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-lg-6 text-center">
                @if($setting->hero_image_home)
                    <img src="{{ asset($setting->hero_image_home) }}" alt="FlyerAll" class="lp-hero-img">
                @else
                    <div class="lp-hero-placeholder"><i class="bi bi-phone"></i></div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="lp-section" id="how-it-works">
    <div class="container-xl">
        <div class="text-center mb-5">
            <h2 class="fw-800" style="font-size:2rem;font-weight:800;">How It Works</h2>
            <p class="lp-lead mx-auto">From sign-up to reward, here's the whole customer journey.</p>
        </div>

        @foreach($steps as $step)
        <div class="lp-step lp-soft-{{ $step->color }}">
            <div class="row align-items-center g-4">
                <div class="col-md-7 {{ $loop->even ? 'order-md-2' : '' }}">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="lp-step-num lp-bg-{{ $step->color }}">{{ $step->number }}</span>
                        <h3 class="lp-step-title mb-0">{{ $step->title }}</h3>
                    </div>
                    <p class="lp-step-desc">{{ $step->description }}</p>
                    @if($step->features->isNotEmpty())
                    <ul class="lp-step-checklist">
                        @foreach($step->features as $feature)
                        <li><i class="bi bi-check-circle-fill lp-c-{{ $step->color }}"></i> {{ $feature->text }}</li>
                        @endforeach
                    </ul>
                    @endif
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

        @if($setting->redeem_banner_text)
        <div class="lp-banner mt-3">{{ $setting->redeem_banner_text }}</div>
        @endif
    </div>
</section>

@endsection

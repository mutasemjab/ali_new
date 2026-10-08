@extends('landing.layouts.app')
@section('title', 'Plans')

@push('styles')
<style>
    .lp-hero-img { width: 100%; max-width: 440px; border-radius: 20px; }
    .lp-hero-placeholder { width: 100%; aspect-ratio: 4/3; border-radius: 20px; background: linear-gradient(135deg, var(--bg-soft), #eef2ff); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 3rem; }

    .lp-plan-card { border-radius: 22px; border: 1px solid var(--border); padding: 26px; height: 100%; position: relative; background: #fff; box-shadow: 0 16px 40px -28px rgba(15,23,42,.35); }
    .lp-plan-card.is-popular { border: 2px solid var(--c-purple); box-shadow: 0 20px 44px -22px rgba(124,58,237,.45); }
    .lp-plan-badge { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--c-purple); color: #fff; font-size: .72rem; font-weight: 800; letter-spacing: .04em; padding: 6px 16px; border-radius: 999px; white-space: nowrap; }
    .lp-plan-icon { width: 48px; height: 48px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 14px; }
    .lp-plan-name { font-weight: 800; font-size: 1.15rem; margin: 0; }
    .lp-plan-subtitle { color: var(--muted); font-size: .85rem; margin-bottom: 14px; }
    .lp-plan-price { font-size: 2.3rem; font-weight: 900; line-height: 1; }
    .lp-plan-price-sub { color: var(--muted); font-size: .8rem; margin-bottom: 16px; }
    .lp-plan-tablets { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; font-size: .85rem; border-radius: 12px; padding: 10px 14px; margin-bottom: 16px; }
    .lp-plan-features { list-style: none; margin: 0 0 18px; padding: 0; }
    .lp-plan-features li { display: flex; align-items: flex-start; gap: 8px; font-size: .88rem; font-weight: 600; margin-bottom: 10px; }
    .lp-plan-rate { font-weight: 800; text-align: center; border-radius: 12px; padding: 10px; margin-bottom: 16px; font-size: .9rem; }
    .lp-plan-cta { display: block; text-align: center; color: #fff; font-weight: 700; border-radius: 12px; padding: 12px; }
    .lp-plan-cta:hover { color: #fff; opacity: .92; }

    .lp-fee-bar { border-radius: 18px; border: 1px solid var(--border); padding: 20px 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; background: var(--bg-soft); margin-top: 16px; }
    .lp-fee-amount { font-size: 1.6rem; font-weight: 900; text-align: right; }

    .lp-highlight-card { border-radius: 18px; border: 1px solid var(--border); padding: 20px; height: 100%; }
    .lp-highlight-icon { width: 44px; height: 44px; border-radius: 12px; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: 12px; }
</style>
@endpush

@section('content')

<section class="lp-section-tight">
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
            </div>
            <div class="col-lg-6 text-center">
                @if($setting->hero_image_plans)
                    <img src="{{ asset($setting->hero_image_plans) }}" alt="FlyerAll" class="lp-hero-img">
                @else
                    <div class="lp-hero-placeholder"><i class="bi bi-phone"></i></div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="lp-section">
    <div class="container-xl">
        <div class="row g-4">
            @foreach($plans as $plan)
            <div class="col-md-6 col-lg-3">
                <div class="lp-plan-card {{ $plan->is_popular ? 'is-popular' : '' }}">
                    @if($plan->is_popular && $plan->badge_text)
                        <div class="lp-plan-badge"><i class="bi bi-star-fill"></i> {{ $plan->badge_text }}</div>
                    @endif

                    <div class="lp-plan-icon lp-bg-{{ $plan->color }}"><i class="bi bi-send-fill"></i></div>
                    <p class="lp-plan-name">{{ $plan->name }}</p>
                    <p class="lp-plan-subtitle">{{ $plan->subtitle }}</p>

                    <div class="lp-plan-price lp-c-{{ $plan->color }}">{{ $plan->price }}</div>
                    <p class="lp-plan-price-sub">{{ $plan->price_subtext }}</p>

                    <div class="lp-plan-tablets lp-soft-{{ $plan->color }} lp-c-{{ $plan->color }}">
                        <i class="bi bi-tablet"></i> {{ $plan->tablets_included }} {{ $plan->tablets_label }}
                    </div>

                    <ul class="lp-plan-features">
                        @foreach($plan->features as $feature)
                        <li><i class="bi bi-check-circle-fill lp-c-{{ $plan->color }}"></i> {{ $feature->text }}</li>
                        @endforeach
                    </ul>

                    @if($plan->rate_text)
                    <div class="lp-plan-rate lp-soft-{{ $plan->color }} lp-c-{{ $plan->color }}">{{ $plan->rate_text }}</div>
                    @endif

                    <a href="{{ $setting->cta_url ?: '#' }}" class="lp-plan-cta lp-bg-{{ $plan->color }}">{{ $plan->cta_text }}</a>
                </div>
            </div>
            @endforeach
        </div>

        @if($setting->monthly_fee_amount)
        <div class="lp-fee-bar">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-gear-fill fs-3 lp-c-primary"></i>
                <div>
                    <div class="fw-800">Monthly Service Fee</div>
                    <div class="text-muted small">Billed separately from text messages.</div>
                </div>
            </div>
            <div class="lp-fee-amount">{{ $setting->monthly_fee_amount }}<div class="text-muted small fw-normal">{{ $setting->monthly_fee_label }}</div></div>
        </div>
        @endif

        @if($footerHighlights->isNotEmpty())
        <div class="row g-3 mt-2">
            @foreach($footerHighlights as $highlight)
            <div class="col-md-3 col-6">
                <div class="lp-highlight-card">
                    <div class="lp-highlight-icon lp-bg-{{ $highlight->color }}"><i class="bi {{ $highlight->icon }}"></i></div>
                    <div class="fw-700" style="font-weight:700;">{{ $highlight->title }}</div>
                    <div class="text-muted small">{{ $highlight->description }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

@endsection

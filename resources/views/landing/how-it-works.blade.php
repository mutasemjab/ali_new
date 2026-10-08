@extends('landing.layouts.app')
@section('title', 'How It Works')

@push('styles')
<style>
    .lp-step { border-radius: 22px; padding: 28px; margin-bottom: 18px; }
    .lp-step-num { width: 44px; height: 44px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; }
    .lp-step-title { font-size: 1.3rem; font-weight: 800; margin: 2px 0 8px; }
    .lp-step-desc { color: var(--muted); font-size: .95rem; line-height: 1.6; }
    .lp-step-checklist { list-style: none; margin: 14px 0 0; padding: 0; }
    .lp-step-checklist li { display: flex; gap: 8px; align-items: flex-start; font-weight: 600; font-size: .9rem; margin-bottom: 8px; }
    .lp-step-img { width: 100%; border-radius: 16px; }
    .lp-step-img-placeholder { width: 100%; aspect-ratio: 3/4; border-radius: 16px; background: rgba(255,255,255,.5); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 2rem; }
</style>
@endpush

@section('content')

<section class="lp-section-tight">
    <div class="container-xl text-center">
        <h1 class="lp-h1">How It <span class="accent">Works</span></h1>
        <p class="lp-lead mx-auto">From the moment a customer walks in, to the moment they redeem a reward — here's the whole journey.</p>
    </div>
</section>

<section class="lp-section">
    <div class="container-xl">
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
    </div>
</section>

@endsection

@extends('landing.layouts.app')
@section('title', $store->name)

@section('content')

<section class="lp-section">
    <div class="container-xl">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="lp-h1">Welcome to <span class="accent">{{ $store->name }}</span></h1>
                <p class="lp-lead">Check out where to find us, follow our socials, or send us a message.</p>
                <a href="{{ route('store-site.contact') }}" class="lp-btn-cta mt-2">Contact Us <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-lg-6 text-center">
                @if($store->photo)
                    <img src="{{ asset($store->photo) }}" alt="{{ $store->name }}" style="width:100%;max-width:320px;aspect-ratio:1;object-fit:cover;border-radius:28px;">
                @else
                    <div style="width:100%;max-width:320px;aspect-ratio:1;margin:0 auto;border-radius:28px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:3rem;">
                        <i class="bi bi-shop"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

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

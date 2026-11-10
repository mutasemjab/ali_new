@extends('landing.layouts.app')
@section('title', 'About')

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">About <span class="accent">{{ $store->name }}</span></h1>

        @if($store->locations->isEmpty() && $store->socials->isEmpty())
            <p class="lp-lead mx-auto text-center" style="max-width:none;">
                We'll have more information about {{ $store->name }} here soon.
            </p>
        @endif

        @if($store->locations->isNotEmpty())
            <div class="mt-5">
                <h2 class="text-center mb-4" style="font-size:1.3rem;font-weight:800;">Find Us</h2>
                <div class="d-flex flex-column gap-3">
                    @foreach($store->locations as $location)
                        <div class="lp-contact-card">
                            <span class="lp-contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
                            <div>
                                <div class="fw-semibold">{{ $location->name }}</div>
                                <div class="text-muted small">{{ $location->address }}</div>
                                @if($location->phone)
                                    <div class="text-muted small">{{ $location->phone }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($store->socials->isNotEmpty())
            <div class="mt-5">
                <h2 class="text-center mb-4" style="font-size:1.3rem;font-weight:800;">Follow Us</h2>
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
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('store-site.contact') }}" class="lp-btn-cta">Contact Us <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

@endsection

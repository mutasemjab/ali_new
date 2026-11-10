@extends('landing.layouts.app')
@section('title', 'About')

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">{{ $store->about_title ?: 'About ' . $store->name }}</h1>
        <p class="lp-lead mx-auto text-center" style="max-width:none;">
            {{ $store->about_body }}
        </p>

        <div class="text-center mt-4">
            <a href="{{ route('store-site.contact') }}" class="lp-btn-cta">Contact Us <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

@endsection

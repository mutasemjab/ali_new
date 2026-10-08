@extends('landing.layouts.app')
@section('title', 'About')

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">{{ $setting->about_title ?: 'About FlyerAll' }}</h1>
        <p class="lp-lead mx-auto text-center" style="max-width:none;">
            {{ $setting->about_body }}
        </p>

        <div class="text-center mt-4">
            <a href="{{ $setting->cta_url ?: '#' }}" class="lp-btn-cta">{{ $setting->cta_text ?: 'Get Started' }} <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

@endsection

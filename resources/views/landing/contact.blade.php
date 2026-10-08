@extends('landing.layouts.app')
@section('title', 'Contact')

@push('styles')
<style>
    .lp-contact-card { border-radius: 20px; border: 1px solid var(--border); padding: 28px; display: flex; align-items: center; gap: 16px; }
    .lp-contact-icon { width: 48px; height: 48px; border-radius: 12px; background: var(--c-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
</style>
@endpush

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">Get In <span class="accent">Touch</span></h1>
        <p class="lp-lead mx-auto text-center" style="max-width:none;">Have a question or want a demo for your store? Reach out any time.</p>

        <div class="row g-3 mt-3">
            @if($setting->contact_email)
            <div class="col-md-6">
                <div class="lp-contact-card">
                    <div class="lp-contact-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <div class="text-muted small">Email</div>
                        <a href="mailto:{{ $setting->contact_email }}" class="fw-700" style="font-weight:700;color:var(--ink);">{{ $setting->contact_email }}</a>
                    </div>
                </div>
            </div>
            @endif
            @if($setting->contact_phone)
            <div class="col-md-6">
                <div class="lp-contact-card">
                    <div class="lp-contact-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <div class="text-muted small">Phone</div>
                        <a href="tel:{{ $setting->contact_phone }}" class="fw-700" style="font-weight:700;color:var(--ink);">{{ $setting->contact_phone }}</a>
                    </div>
                </div>
            </div>
            @endif
            @if($setting->contact_address)
            <div class="col-12">
                <div class="lp-contact-card">
                    <div class="lp-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <div class="text-muted small">Address</div>
                        <div class="fw-700" style="font-weight:700;">{{ $setting->contact_address }}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection

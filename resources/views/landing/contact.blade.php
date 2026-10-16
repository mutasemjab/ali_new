@extends('landing.layouts.app')
@section('title', 'Contact')

@push('styles')
<style>
    .lp-contact-card { border-radius: 20px; border: 1px solid var(--border); padding: 28px; display: flex; align-items: center; gap: 16px; }
    .lp-contact-icon { width: 48px; height: 48px; border-radius: 12px; background: var(--c-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }

    .lp-contact-form { border-radius: 22px; border: 1px solid var(--border); padding: 30px; box-shadow: 0 16px 40px -28px rgba(15,23,42,.35); }
    .lp-contact-form .form-label { font-weight: 600; font-size: .88rem; }
    .lp-contact-form .form-control { border-radius: 10px; border-color: var(--border); padding: 11px 14px; }
    .lp-contact-form .form-control:focus { border-color: var(--c-primary); box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
    .lp-consent { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; border-radius: 12px; background: var(--bg-soft); margin-bottom: 10px; }
    .lp-consent input[type="checkbox"] { margin-top: 3px; flex-shrink: 0; width: 18px; height: 18px; }
    .lp-consent label { font-size: .82rem; color: var(--muted); line-height: 1.5; margin: 0; }
    .lp-consent label strong { color: var(--ink); display: block; font-size: .85rem; margin-bottom: 2px; }
    .lp-contact-submit { border: none; border-radius: 12px; padding: 13px; font-weight: 700; color: #fff; background: linear-gradient(135deg, var(--c-primary), var(--c-purple)); width: 100%; }
</style>
@endpush

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">Get In <span class="accent">Touch</span></h1>
        <p class="lp-lead mx-auto text-center" style="max-width:none;">Have a question or want a demo for your store? Send us a message below.</p>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('landing.contact.store') }}" method="POST" class="lp-contact-form mt-4">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <div class="lp-consent">
                    <input type="checkbox" name="consent_non_marketing" id="consentNonMarketing" value="1" {{ old('consent_non_marketing') ? 'checked' : '' }}>
                    <label for="consentNonMarketing">
                        <strong>Non-Marketing Consent</strong>
                        I agree to receive non-marketing SMS messages from FlyerAll regarding my inquiries, account assistance, platform support, customer sign-up assistance, loyalty program account information, service updates, and customer support communications. Message frequency may vary. Reply "HELP" for assistance or "STOP" to unsubscribe. Standard message and data rates may apply.
                    </label>
                </div>

                <div class="lp-consent">
                    <input type="checkbox" name="consent_marketing" id="consentMarketing" value="1" {{ old('consent_marketing') ? 'checked' : '' }}>
                    <label for="consentMarketing">
                        <strong>Marketing Consent</strong>
                        I agree to receive marketing SMS messages from FlyerAll regarding promotional offers, discounts, and related marketing communications. Message frequency may vary. Reply "HELP" for assistance or "STOP" to unsubscribe. Standard message and data rates may apply.
                    </label>
                </div>

                <div class="lp-consent">
                    <input type="checkbox" name="consent_terms" id="consentTerms" value="1" {{ old('consent_terms') ? 'checked' : '' }}>
                    <label for="consentTerms">
                        I agree with the <a href="{{ route('landing.privacy-policy') }}" target="_blank" class="lp-c-primary">Privacy Policy</a> and <a href="{{ route('landing.terms-of-service') }}" target="_blank" class="lp-c-primary">Terms and Conditions</a>.
                    </label>
                </div>
            </div>

            <button type="submit" class="lp-contact-submit mt-2">Send Message <i class="bi bi-arrow-right"></i></button>
        </form>

        <div class="row g-3 mt-2">
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

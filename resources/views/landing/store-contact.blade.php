@extends('landing.layouts.app')
@section('title', 'Contact')

@push('styles')
<style>
    .lp-contact-form { border-radius: 22px; border: 1px solid var(--border); padding: 30px; box-shadow: 0 16px 40px -28px rgba(15,23,42,.35); }
    .lp-contact-form .form-label { font-weight: 600; font-size: .88rem; }
    .lp-contact-form .form-control { border-radius: 10px; border-color: var(--border); padding: 11px 14px; }
    .lp-contact-form .form-control:focus { border-color: var(--c-primary); box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
    .lp-contact-submit { border: none; border-radius: 12px; padding: 13px; font-weight: 700; color: #fff; background: linear-gradient(135deg, var(--c-primary), var(--c-purple)); width: 100%; }
</style>
@endpush

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">Get In <span class="accent">Touch</span></h1>
        <p class="lp-lead mx-auto text-center" style="max-width:none;">Have a question for {{ $store->name }}? Send us a message below.</p>

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

        <form action="{{ route('store-site.contact.store') }}" method="POST" class="lp-contact-form mt-4">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
                </div>
            </div>

            <button type="submit" class="lp-contact-submit mt-4">Send Message</button>
        </form>
    </div>
</section>

@endsection

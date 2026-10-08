@extends('admin.layouts.app')
@section('title', 'Landing Page Settings')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Landing Page Settings</h1>
        <p class="page-sub">General content shown on the FlyerAll marketing site (flyerall.net)</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.landing-settings.update') }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-image"></i> Hero Section</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Hero Title</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}" class="form-control" placeholder="Grow Your Store with FlyerAll">
            </div>
            <div class="col-md-6">
                <label class="form-label">Hero Subtitle</label>
                <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $setting->hero_subtitle) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Hero Image — Home Page</label>
                <input type="file" name="hero_image_home" class="form-control" accept="image/*">
                @if($setting->hero_image_home)
                    <img src="{{ asset($setting->hero_image_home) }}" alt="" class="mt-2" style="max-width:200px;border-radius:8px;">
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">Hero Image — Plans Page</label>
                <input type="file" name="hero_image_plans" class="form-control" accept="image/*">
                @if($setting->hero_image_plans)
                    <img src="{{ asset($setting->hero_image_plans) }}" alt="" class="mt-2" style="max-width:200px;border-radius:8px;">
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">"Get Started" Button Text</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $setting->cta_text) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">"Get Started" Button Link</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $setting->cta_url) }}" class="form-control" placeholder="https://...">
            </div>
        </div>
    </div>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-cash-coin"></i> Monthly Service Fee</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Amount</label>
                <input type="text" name="monthly_fee_amount" value="{{ old('monthly_fee_amount', $setting->monthly_fee_amount) }}" class="form-control" placeholder="$125">
            </div>
            <div class="col-md-6">
                <label class="form-label">Label</label>
                <input type="text" name="monthly_fee_label" value="{{ old('monthly_fee_label', $setting->monthly_fee_label) }}" class="form-control" placeholder="per month">
            </div>
        </div>
    </div>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-megaphone"></i> Redeem Banner (Home Page)</h2>
    </div>
    <div class="panel-card-body">
        <textarea name="redeem_banner_text" rows="2" class="form-control">{{ old('redeem_banner_text', $setting->redeem_banner_text) }}</textarea>
    </div>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-info-circle"></i> About Page</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Title</label>
                <input type="text" name="about_title" value="{{ old('about_title', $setting->about_title) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Body</label>
                <textarea name="about_body" rows="5" class="form-control">{{ old('about_body', $setting->about_body) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-envelope"></i> Contact Page</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $setting->contact_email) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Address</label>
                <input type="text" name="contact_address" value="{{ old('contact_address', $setting->contact_address) }}" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
</div>

</form>

@endsection

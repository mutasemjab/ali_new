@extends('store.layouts.app')
@section('title', 'Public Page')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Public Page</h1>
        <p class="page-sub">Facebook link and which icons show in the mobile app</p>
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

<div class="panel-card mb-3">
    <div class="panel-card-body">
        <div class="row g-2 small text-muted">
            <div class="col-12">Public feedback link: <a href="{{ route('public.stores.feedback.create', $store->id) }}" target="_blank">{{ route('public.stores.feedback.create', $store->id) }}</a></div>
        </div>
    </div>
</div>

<form action="{{ route('store.pages.update') }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-facebook"></i> Facebook Link</h2>
    </div>
    <div class="panel-card-body">
        <input type="url" name="facebook_link" value="{{ old('facebook_link', $store->facebook_link) }}" class="form-control" placeholder="https://facebook.com/your-page">
    </div>
</div>

<div class="panel-card mt-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-grid-3x3-gap"></i> Mobile App Icons</h2>
    </div>
    <div class="panel-card-body">
        <p class="text-muted small mb-3">Turn off any feature you don't want to appear as an icon on your customers' home screen.</p>
        <div class="row g-3">
            @php
                $icons = [
                    'show_in_store_deals' => ['In-Store Deals', 'bi-tags'],
                    'show_social' => ['Social', 'bi-share'],
                    'show_qr' => ['QR Code', 'bi-qr-code'],
                    'show_weekly_ads' => ['Weekly Ads', 'bi-calendar-week'],
                    'show_coupons' => ['Coupons', 'bi-ticket-perforated'],
                    'show_location' => ['Location', 'bi-geo-alt'],
                    'show_rewards' => ['Rewards', 'bi-trophy'],
                ];
            @endphp
            @foreach($icons as $field => [$label, $icon])
            <div class="col-md-4">
                <label class="d-flex align-items-center gap-2 p-2 rounded border">
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" role="switch" name="{{ $field }}" value="1"
                            {{ old($field, $store->$field) ? 'checked' : '' }}>
                    </div>
                    <i class="bi {{ $icon }}"></i>
                    <span>{{ $label }}</span>
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
</div>

</form>

@endsection

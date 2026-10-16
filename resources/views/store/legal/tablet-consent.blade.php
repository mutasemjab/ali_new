@extends('store.layouts.app')
@section('title', 'Tablet Consent Screen')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Tablet Consent Screen</h1>
        <p class="page-sub">The short message shown on the tablet's "Review &amp; Agree" step, before a customer taps "I Agree"</p>
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

<form action="{{ route('store.legal.tablet-consent.update') }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-tablet"></i> Tablet Consent Screen</h2>
    </div>
    <div class="panel-card-body">
        <textarea name="tablet_consent_text" rows="8" class="form-control" placeholder="e.g. By clicking &quot;I Agree&quot;, you are consenting to receive text messages from this store, which may include weekly ads, exclusive discounts on goods and services, and other promotions. Message and data rates may apply.">{{ old('tablet_consent_text', $store->tablet_consent_text) }}</textarea>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
</div>

</form>

@endsection

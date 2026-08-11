@extends('store.layouts.app')
@section('title', 'Public Page')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Public Page</h1>
        <p class="page-sub">Privacy policy and Facebook link shown to clients</p>
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
            <div class="col-12">Public privacy policy link: <a href="{{ route('public.stores.privacy', $store->id) }}" target="_blank">{{ route('public.stores.privacy', $store->id) }}</a></div>
            <div class="col-12">Public feedback link: <a href="{{ route('public.stores.feedback.create', $store->id) }}" target="_blank">{{ route('public.stores.feedback.create', $store->id) }}</a></div>
        </div>
    </div>
</div>

<form action="{{ route('store.pages.update') }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-shield-check"></i> Privacy Policy</h2>
    </div>
    <div class="panel-card-body">
        <textarea name="privacy_policy" rows="8" class="form-control" placeholder="Write your store's privacy policy...">{{ old('privacy_policy', $store->privacy_policy) }}</textarea>
    </div>
</div>

<div class="panel-card mt-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-facebook"></i> Facebook Link</h2>
    </div>
    <div class="panel-card-body">
        <input type="url" name="facebook_link" value="{{ old('facebook_link', $store->facebook_link) }}" class="form-control" placeholder="https://facebook.com/your-page">
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
</div>

</form>

@endsection

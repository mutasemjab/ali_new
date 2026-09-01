@extends('admin.layouts.app')
@section('title', 'Anti-Spam Policy')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Anti-Spam Policy</h1>
        <p class="page-sub">Shown to clients across all stores in the mobile app and tablet kiosk</p>
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

<form action="{{ route('admin.settings.anti-spam.update') }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-envelope-slash"></i> Anti-Spam Policy</h2>
    </div>
    <div class="panel-card-body">
        <textarea name="anti_spam_policy" rows="12" class="form-control" placeholder="Write the anti-spam policy shown to clients...">{{ old('anti_spam_policy', $setting->anti_spam_policy) }}</textarea>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
</div>

</form>

@endsection

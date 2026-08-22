@extends('store.layouts.app')
@section('title', 'Generate New QR Code')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Generate New QR Code</h1>
        <p class="page-sub">Enter a link and a QR code image will be generated for it automatically</p>
    </div>
    <a href="{{ route('store.qrs.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.qrs.store') }}" method="POST">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-qr-code"></i> QR Code Details</h2>
    </div>
    <div class="panel-card-body">
        <label class="form-label">Link <span class="text-danger">*</span></label>
        <input type="url" name="link" value="{{ old('link') }}" class="form-control" placeholder="https://..." required>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Generate QR Code</button>
    <a href="{{ route('store.qrs.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

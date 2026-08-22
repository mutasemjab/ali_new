@extends('store.layouts.app')
@section('title', 'Send New Notification')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Send New Notification</h1>
    </div>
    <a href="{{ route('store.notifications.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.notifications.store') }}" method="POST">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-bell"></i> Notification Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Body <span class="text-danger">*</span></label>
                <textarea name="body" class="form-control" rows="3" required>{{ old('body') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Send Notification</button>
    <a href="{{ route('store.notifications.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

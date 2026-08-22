@extends('store.layouts.app')
@section('title', 'Add New Weekly Ad')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Weekly Ad</h1>
    </div>
    <a href="{{ route('store.weekly-ads.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.weekly-ads.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-calendar-week"></i> Weekly Ad Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Photo <span class="text-danger">*</span></label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                <input type="date" name="start_at" value="{{ old('start_at') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">End Date <span class="text-danger">*</span></label>
                <input type="date" name="end_at" value="{{ old('end_at') }}" class="form-control" required>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Weekly Ad</button>
    <a href="{{ route('store.weekly-ads.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

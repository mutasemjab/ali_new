@extends('admin.layouts.app')
@section('title', 'Add New Step')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Step</h1>
    </div>
    <a href="{{ route('admin.landing-steps.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.landing-steps.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-list-ol"></i> Step Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Step Number <span class="text-danger">*</span></label>
                <input type="number" min="1" name="number" value="{{ old('number', 1) }}" class="form-control" required>
            </div>
            <div class="col-md-9">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="e.g. Customer Enters Phone Number" required>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Color <span class="text-danger">*</span></label>
                <select name="color" class="form-select" required>
                    @foreach(['primary' => 'Blue', 'danger' => 'Red/Pink', 'purple' => 'Purple', 'orange' => 'Orange', 'success' => 'Green', 'warning' => 'Yellow'] as $value => $label)
                        <option value="{{ $value }}" {{ old('color') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Checklist (one per line)</label>
                <textarea name="features_text" rows="4" class="form-control" placeholder="Quick & easy sign up&#10;One time per day&#10;Built for your store">{{ old('features_text') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Step</button>
    <a href="{{ route('admin.landing-steps.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

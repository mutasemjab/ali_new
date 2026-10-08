@extends('admin.layouts.app')
@section('title', 'Edit Plan')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Plan</h1>
        <p class="page-sub">{{ $plan->name }}</p>
    </div>
    <a href="{{ route('admin.landing-plans.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.landing-plans.update', $plan->id) }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-credit-card"></i> Plan Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $plan->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $plan->subtitle) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <input type="text" name="price" value="{{ old('price', $plan->price) }}" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Price Subtext</label>
                <input type="text" name="price_subtext" value="{{ old('price_subtext', $plan->price_subtext) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tablets Included <span class="text-danger">*</span></label>
                <input type="number" min="0" name="tablets_included" value="{{ old('tablets_included', $plan->tablets_included) }}" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Tablets Label</label>
                <input type="text" name="tablets_label" value="{{ old('tablets_label', $plan->tablets_label) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Rate Text</label>
                <input type="text" name="rate_text" value="{{ old('rate_text', $plan->rate_text) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Color <span class="text-danger">*</span></label>
                <select name="color" class="form-select" required>
                    @foreach(['primary' => 'Blue', 'danger' => 'Red/Pink', 'purple' => 'Purple', 'orange' => 'Orange', 'success' => 'Green', 'warning' => 'Yellow'] as $value => $label)
                        <option value="{{ $value }}" {{ old('color', $plan->color) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Button Text <span class="text-danger">*</span></label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $plan->cta_text) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input" role="switch" name="is_popular" value="1" {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}>
                    <label class="form-check-label">Mark as "Most Popular"</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Badge Text (shown when "Most Popular" is on)</label>
                <input type="text" name="badge_text" value="{{ old('badge_text', $plan->badge_text) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Features (one per line)</label>
                <textarea name="features_text" rows="5" class="form-control">{{ old('features_text', $plan->features->pluck('text')->implode("\n")) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('admin.landing-plans.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

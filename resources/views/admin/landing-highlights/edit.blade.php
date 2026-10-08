@extends('admin.layouts.app')
@section('title', 'Edit Highlight')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Highlight</h1>
        <p class="page-sub">{{ $highlight->title }}</p>
    </div>
    <a href="{{ route('admin.landing-highlights.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.landing-highlights.update', $highlight->id) }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-stars"></i> Highlight Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Shown On <span class="text-danger">*</span></label>
                <select name="section" class="form-select" required>
                    <option value="home_hero" {{ old('section', $highlight->section) === 'home_hero' ? 'selected' : '' }}>Home Page — Hero Badges</option>
                    <option value="plans_footer" {{ old('section', $highlight->section) === 'plans_footer' ? 'selected' : '' }}>Plans Page — Footer Cards</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Icon <span class="text-danger">*</span></label>
                <input type="text" name="icon" value="{{ old('icon', $highlight->icon) }}" class="form-control" required>
                <div class="form-text">Any <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener">Bootstrap Icons</a> class name.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title', $highlight->title) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Color <span class="text-danger">*</span></label>
                <select name="color" class="form-select" required>
                    @foreach(['primary' => 'Blue', 'danger' => 'Red/Pink', 'purple' => 'Purple', 'orange' => 'Orange', 'success' => 'Green', 'warning' => 'Yellow'] as $value => $label)
                        <option value="{{ $value }}" {{ old('color', $highlight->color) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Description (optional — used on the Plans page cards)</label>
                <input type="text" name="description" value="{{ old('description', $highlight->description) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $highlight->sort_order) }}" class="form-control" required>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('admin.landing-highlights.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

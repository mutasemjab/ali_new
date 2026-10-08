@extends('admin.layouts.app')
@section('title', 'Edit Step')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Step</h1>
        <p class="page-sub">{{ $step->title }}</p>
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

<form action="{{ route('admin.landing-steps.update', $step->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-list-ol"></i> Step Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Step Number <span class="text-danger">*</span></label>
                <input type="number" min="1" name="number" value="{{ old('number', $step->number) }}" class="form-control" required>
            </div>
            <div class="col-md-9">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title', $step->title) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $step->description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if($step->image)
                    <img src="{{ asset($step->image) }}" alt="" class="mt-2" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                @endif
            </div>
            <div class="col-md-3">
                <label class="form-label">Color <span class="text-danger">*</span></label>
                <select name="color" class="form-select" required>
                    @foreach(['primary' => 'Blue', 'danger' => 'Red/Pink', 'purple' => 'Purple', 'orange' => 'Orange', 'success' => 'Green', 'warning' => 'Yellow'] as $value => $label)
                        <option value="{{ $value }}" {{ old('color', $step->color) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $step->sort_order) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Checklist (one per line)</label>
                <textarea name="features_text" rows="4" class="form-control">{{ old('features_text', $step->features->pluck('text')->implode("\n")) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('admin.landing-steps.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

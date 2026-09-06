@extends('store.layouts.app')
@section('title', 'Edit Career')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Career</h1>
        <p class="page-sub">{{ $career->title }}</p>
    </div>
    <a href="{{ route('store.careers.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.careers.update', $career->id) }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-briefcase"></i> Career Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title', $career->title) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $career->description) }}</textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
window.__existingSpecifications = @json($career->specifications->map(function ($spec) {
    return [
        'id' => $spec->id,
        'name' => $spec->name,
        'type' => $spec->type,
        'validation' => $spec->validation,
        'available_report' => $spec->available_report,
        'values_text' => $spec->values->pluck('value')->implode("\n"),
    ];
}));
</script>
@endpush

@include('store.careers._spec-fields')

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.careers.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

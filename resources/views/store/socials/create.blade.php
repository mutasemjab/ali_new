@extends('store.layouts.app')
@section('title', 'Add New Social Link')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Social Link</h1>
    </div>
    <a href="{{ route('store.socials.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.socials.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-share"></i> Social Link Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Facebook" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Link <span class="text-danger">*</span></label>
                <input type="url" name="link" value="{{ old('link') }}" class="form-control" placeholder="https://..." required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Icon <span class="text-danger">*</span></label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Social Link</button>
    <a href="{{ route('store.socials.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

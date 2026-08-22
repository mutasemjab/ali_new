@extends('store.layouts.app')
@section('title', 'Edit Social Link')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Social Link</h1>
        <p class="page-sub">{{ $social->name }}</p>
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

<form action="{{ route('store.socials.update', $social->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-share"></i> Social Link Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $social->name) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Link <span class="text-danger">*</span></label>
                <input type="url" name="link" value="{{ old('link', $social->link) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Icon</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
                <img src="{{ asset($social->photo) }}" alt="" class="mt-2" style="width:32px;height:32px;object-fit:cover;border-radius:6px;">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.socials.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

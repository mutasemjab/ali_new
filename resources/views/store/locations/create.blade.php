@extends('store.layouts.app')
@section('title', 'Add New Location')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Location</h1>
    </div>
    <a href="{{ route('store.locations.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.locations.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-geo-alt"></i> Location Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Latitude <span class="text-danger">*</span></label>
                <input type="text" name="lat" value="{{ old('lat') }}" class="form-control" placeholder="e.g. 31.9539" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Longitude <span class="text-danger">*</span></label>
                <input type="text" name="lng" value="{{ old('lng') }}" class="form-control" placeholder="e.g. 35.9106" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Location</button>
    <a href="{{ route('store.locations.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

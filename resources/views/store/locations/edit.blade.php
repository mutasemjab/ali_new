@extends('store.layouts.app')
@section('title', 'Edit Location')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Location</h1>
        <p class="page-sub">{{ $location->name }}</p>
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

<form action="{{ route('store.locations.update', $location->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-geo-alt"></i> Location Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $location->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $location->phone) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="{{ old('address', $location->address) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Google Maps Link <span class="text-danger">*</span></label>
                <input type="url" name="maps_link" value="{{ old('maps_link', 'https://maps.google.com/?q=' . $location->lat . ',' . $location->lng) }}" class="form-control" required>
                <div class="form-text">Open the location in Google Maps, tap Share, copy the link, and paste it here — the coordinates are read automatically.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
                @if($location->photo)
                    <img src="{{ asset($location->photo) }}" alt="" class="mt-2" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.locations.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

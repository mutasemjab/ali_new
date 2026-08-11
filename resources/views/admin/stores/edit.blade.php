@extends('admin.layouts.app')
@section('title', 'Edit Store')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Store</h1>
        <p class="page-sub">{{ $store->name }}</p>
    </div>
    <a href="{{ route('admin.stores.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.stores.update', $store->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-shop"></i> Store Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Store Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $store->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email', $store->email) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Store Logo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label">New Password (optional)</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password">
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('admin.stores.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

@extends('admin.layouts.app')
@section('title', 'Add New Store')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Store</h1>
        <p class="page-sub">Create a new store account on the platform</p>
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

<form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-shop"></i> Store Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Store Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Store Logo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" autocomplete="new-password" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tablet PIN</label>
                <input type="text" name="pin" value="{{ old('pin') }}" class="form-control" maxlength="10" placeholder="e.g. 1234">
                <div class="form-text">Given to the store to unlock their tablet kiosk. Leave empty to set later.</div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Store</button>
    <a href="{{ route('admin.stores.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

@extends('store.layouts.app')
@section('title', 'Edit Coupon')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Coupon</h1>
        <p class="page-sub">{{ $coupon->name }}</p>
    </div>
    <a href="{{ route('store.coupons.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-ticket-perforated"></i> Coupon Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Coupon Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $coupon->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
                <img src="{{ asset($coupon->photo) }}" alt="" class="mt-2" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
            </div>
            <div class="col-12">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="3" required>{{ old('description', $coupon->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Terms &amp; Conditions <span class="text-danger">*</span></label>
                <textarea name="terms" class="form-control" rows="3" required>{{ old('terms', $coupon->terms) }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="clip" {{ old('status', $coupon->status) === 'clip' ? 'selected' : '' }}>Clip</option>
                    <option value="active" {{ old('status', $coupon->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ old('status', $coupon->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Time When Clipped (minutes) <span class="text-danger">*</span></label>
                <input type="number" min="1" name="time_when_clipped" value="{{ old('time_when_clipped', $coupon->time_when_clipped) }}" class="form-control" required>
                <div class="form-text">Countdown shown to the client after they clip this coupon.</div>
            </div>
        </div>
    </div>
</div>

<div class="panel-card mt-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-tag"></i> Pricing</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <input type="text" name="price" value="{{ old('price', $coupon->price) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Price After Discount <span class="text-danger">*</span></label>
                <input type="text" name="price_after_discount" value="{{ old('price_after_discount', $coupon->price_after_discount) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Save Price <span class="text-danger">*</span></label>
                <input type="text" name="save_price" value="{{ old('save_price', $coupon->save_price) }}" class="form-control" required>
            </div>
        </div>
    </div>
</div>

<div class="panel-card mt-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-calendar-range"></i> Validity</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Start At <span class="text-danger">*</span></label>
                <input type="datetime-local" name="start_at" value="{{ old('start_at', $coupon->start_at->format('Y-m-d\TH:i')) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">End At <span class="text-danger">*</span></label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at', $coupon->end_at->format('Y-m-d\TH:i')) }}" class="form-control" required>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.coupons.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

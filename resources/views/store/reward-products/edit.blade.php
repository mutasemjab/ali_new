@extends('store.layouts.app')
@section('title', 'Edit Reward')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Reward</h1>
        <p class="page-sub">{{ $rewardProduct->name }}</p>
    </div>
    <a href="{{ route('store.reward-products.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.reward-products.update', $rewardProduct->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-trophy"></i> Reward Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $rewardProduct->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Visits Required <span class="text-danger">*</span></label>
                <input type="number" min="1" name="visits_required" value="{{ old('visits_required', $rewardProduct->visits_required) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Photo</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <img src="{{ asset($rewardProduct->image) }}" alt="" class="mt-2" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.reward-products.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

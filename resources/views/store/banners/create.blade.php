@extends('store.layouts.app')
@section('title', 'Add New Banner')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Banner</h1>
    </div>
    <a href="{{ route('store.banners.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.banners.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-image"></i> Banner Image</h2>
    </div>
    <div class="panel-card-body">
        <input type="file" name="photo" class="form-control" accept="image/*" required>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Banner</button>
    <a href="{{ route('store.banners.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

@extends('store.layouts.app')
@section('title', 'Add New Product')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Add New Product</h1>
    </div>
    <a href="{{ route('store.products.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($categories->isEmpty())
    <div class="alert alert-warning">
        You need to add at least one category before adding products. <a href="{{ route('store.categories.create') }}">Add a category</a>
    </div>
@endif

<form action="{{ route('store.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-box-seam"></i> Product Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Product Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <input type="text" name="price_usd" value="{{ old('price_usd') }}" class="form-control" placeholder="e.g. $10.99" required>
            </div>
        </div>
    </div>
</div>

<div class="panel-card mt-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-percent"></i> Discount (optional)</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Price After Discount</label>
                <input type="text" name="price_after" value="{{ old('price_after') }}" class="form-control" placeholder="e.g. $7.99">
            </div>
            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="discount_from" value="{{ old('discount_from') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="discount_to" value="{{ old('discount_to') }}" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Product</button>
    <a href="{{ route('store.products.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

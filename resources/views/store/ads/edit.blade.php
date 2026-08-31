@extends('store.layouts.app')
@section('title', 'Edit Ad')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Ad</h1>
        <p class="page-sub">Link: {{ $ad->public_url }}</p>
    </div>
    <a href="{{ route('store.ads.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<input type="hidden" name="type" value="{{ $ad->type }}">

@if($ad->type === 'image')
<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-images"></i> Ad Images</h2>
    </div>
    <div class="panel-card-body">
        @if($ad->images->isNotEmpty())
        <div class="row g-2 mb-3">
            @foreach($ad->images as $image)
            <div class="col-auto text-center">
                <img src="{{ asset($image->image) }}" alt="" style="width:90px;height:90px;object-fit:cover;border-radius:6px;" class="mb-1 d-block">
                <label class="small text-danger d-flex align-items-center gap-1 justify-content-center">
                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Remove
                </label>
            </div>
            @endforeach
        </div>
        @endif
        <label class="form-label">Add more images</label>
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
    </div>
</div>
@else
<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-box-seam"></i> Select Products</h2>
    </div>
    <div class="panel-card-body">
        @php $selected = old('products', $ad->products->pluck('id')->all()); @endphp
        @if($products->isEmpty())
            <p class="text-muted small mb-0">No products added yet. <a href="{{ route('store.products.create') }}">Add a product</a></p>
        @else
        <div class="row g-2">
            @foreach($products as $product)
            <div class="col-md-4">
                <label class="d-flex align-items-center gap-2 p-2 rounded border">
                    <input type="checkbox" name="products[]" value="{{ $product->id }}"
                           {{ in_array($product->id, $selected) ? 'checked' : '' }}>
                    <img src="{{ asset($product->image) }}" alt="" style="width:32px;height:32px;object-fit:cover;border-radius:6px;">
                    <span>{{ $product->name }} — {{ $product->price_usd }}</span>
                </label>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-calendar-x"></i> Expiration (optional)</h2>
    </div>
    <div class="panel-card-body">
        <label class="form-label">Link expires at</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at', optional($ad->expires_at)->format('Y-m-d\TH:i')) }}" class="form-control" style="max-width:280px;">
        <div class="form-text">Leave empty for a link that never expires.</div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.ads.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

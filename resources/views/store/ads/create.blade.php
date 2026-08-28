@extends('store.layouts.app')
@section('title', 'Create New Ad')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Create New Ad</h1>
        <p class="page-sub">Choose an image or a set of products, and after saving you'll get a link ready to send to clients</p>
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

<form action="{{ route('store.ads.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-megaphone"></i> Ad Type</h2>
    </div>
    <div class="panel-card-body">
        <div class="d-flex gap-4">
            <div class="form-check">
                <input type="radio" name="type" value="image" id="type_image" class="form-check-input ad-type-radio" {{ old('type', 'image') === 'image' ? 'checked' : '' }}>
                <label class="form-check-label" for="type_image">Image</label>
            </div>
            <div class="form-check">
                <input type="radio" name="type" value="products" id="type_products" class="form-check-input ad-type-radio" {{ old('type') === 'products' ? 'checked' : '' }}>
                <label class="form-check-label" for="type_products">Products</label>
            </div>
        </div>
    </div>
</div>

<div class="panel-card mb-3" id="image-section">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-images"></i> Ad Images</h2>
    </div>
    <div class="panel-card-body">
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        <div class="form-text">You can select more than one image — clients will be able to swipe through them.</div>
    </div>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-calendar-x"></i> Expiration (optional)</h2>
    </div>
    <div class="panel-card-body">
        <label class="form-label">Link expires at</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="form-control" style="max-width:280px;">
        <div class="form-text">Leave empty for a link that never expires. After this date, the public link will show as expired.</div>
    </div>
</div>

<div class="panel-card mb-3" id="products-section" style="display:none;">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-box-seam"></i> Select Products</h2>
    </div>
    <div class="panel-card-body">
        @if($products->isEmpty())
            <p class="text-muted small mb-0">No products added yet. <a href="{{ route('store.products.create') }}">Add a product</a></p>
        @else
        <div class="row g-2">
            @foreach($products as $product)
            <div class="col-md-4">
                <label class="d-flex align-items-center gap-2 p-2 rounded border">
                    <input type="checkbox" name="products[]" value="{{ $product->id }}"
                           {{ in_array($product->id, old('products', [])) ? 'checked' : '' }}>
                    <img src="{{ asset($product->image) }}" alt="" style="width:32px;height:32px;object-fit:cover;border-radius:6px;">
                    <span>{{ $product->name }} — ${{ $product->price_usd }}</span>
                </label>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Create Ad</button>
    <a href="{{ route('store.ads.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@push('scripts')
<script>
function toggleAdSections() {
    var isProducts = document.getElementById('type_products').checked;
    document.getElementById('image-section').style.display = isProducts ? 'none' : '';
    document.getElementById('products-section').style.display = isProducts ? '' : 'none';
}
document.querySelectorAll('.ad-type-radio').forEach(function (r) {
    r.addEventListener('change', toggleAdSections);
});
toggleAdSections();
</script>
@endpush

@endsection

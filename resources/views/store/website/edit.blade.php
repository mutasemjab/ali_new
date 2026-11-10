@extends('store.layouts.app')
@section('title', 'Website')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Website</h1>
        <p class="page-sub">What customers see on your own site — the Home and About pages, and your How It Works steps</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($store->subdomain)
    <div class="panel-card mb-3">
        <div class="panel-card-body">
            <div class="small text-muted">
                Your website: <a href="https://{{ $store->subdomain }}.flyerall.net" target="_blank">{{ $store->subdomain }}.flyerall.net</a>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('store.website.update') }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-house-door"></i> Home Page Hero</h2>
    </div>
    <div class="panel-card-body">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="hero_title" value="{{ old('hero_title', $store->hero_title) }}" class="form-control" placeholder="e.g. Welcome to {{ $store->name }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <textarea name="hero_subtitle" rows="2" class="form-control" placeholder="A short line under the title">{{ old('hero_subtitle', $store->hero_subtitle) }}</textarea>
        </div>
        <div class="mb-0">
            <label class="form-label">Hero Image</label>
            <input type="file" name="hero_image" class="form-control" accept="image/*">
            @if($store->hero_image)
                <img src="{{ asset($store->hero_image) }}" alt="" class="mt-2" style="width:160px;height:120px;object-fit:cover;border-radius:6px;">
            @endif
        </div>
    </div>
</div>

<div class="panel-card mt-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-info-circle"></i> About Page</h2>
    </div>
    <div class="panel-card-body">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="about_title" value="{{ old('about_title', $store->about_title) }}" class="form-control" placeholder="e.g. About {{ $store->name }}">
        </div>
        <div class="mb-0">
            <label class="form-label">Body</label>
            <textarea name="about_body" rows="5" class="form-control" placeholder="Tell customers about your store">{{ old('about_body', $store->about_body) }}</textarea>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-3 mb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
</div>

</form>

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-list-ol"></i> How It Works Steps</h2>
    </div>
    <div class="panel-card-body">
        <p class="text-muted small mb-3">Shown on your Home page and on your How It Works page, in this order.</p>

        @forelse($steps as $step)
            <form action="{{ route('store.website.steps.update', $step) }}" method="POST" enctype="multipart/form-data" class="border rounded p-3 mb-3">
                @csrf @method('PUT')
                <div class="row g-3 align-items-start">
                    <div class="col-md-5">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" value="{{ $step->title }}" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="2" class="form-control">{{ $step->description }}</textarea>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                        @if($step->image)
                            <img src="{{ asset($step->image) }}" alt="" class="mt-2" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:6px;">
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save</button>
                </div>
            </form>
        @empty
            <p class="text-muted small">No steps yet — add your first one below.</p>
        @endforelse

        <form action="{{ route('store.website.steps.store') }}" method="POST" enctype="multipart/form-data" class="border rounded p-3 mt-3" style="background:var(--bg-soft, #f8fafc);">
            @csrf
            <div class="row g-3 align-items-start">
                <div class="col-md-5">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="2" class="form-control"></textarea>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-plus-lg"></i> Add Step</button>
            </div>
        </form>
    </div>
</div>

@if($steps->isNotEmpty())
    <div class="panel-card mt-3 mb-4">
        <div class="panel-card-header">
            <h2 class="panel-card-title text-danger"><i class="bi bi-trash"></i> Remove a Step</h2>
        </div>
        <div class="panel-card-body">
            @foreach($steps as $step)
                <form action="{{ route('store.website.steps.destroy', $step) }}" method="POST" class="d-flex align-items-center justify-content-between mb-2" onsubmit="return confirm('Remove this step?');">
                    @csrf @method('DELETE')
                    <span>{{ $step->title }}</span>
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Remove</button>
                </form>
            @endforeach
        </div>
    </div>
@endif

@endsection

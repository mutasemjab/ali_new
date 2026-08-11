@extends('store.layouts.app')
@section('title', 'Edit Client')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Edit Client</h1>
        <p class="page-sub">{{ $client->name }}</p>
    </div>
    <a href="{{ route('store.clients.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.clients.update', $client->id) }}" method="POST">
@csrf @method('PUT')

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-person-badge"></i> Client Details</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Number of Visits</label>
                <input type="number" min="0" name="number_of_visit" value="{{ old('number_of_visit', $client->number_of_visit) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Points</label>
                <input type="number" min="0" name="total_points" value="{{ old('total_points', $client->total_points) }}" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
    <a href="{{ route('store.clients.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

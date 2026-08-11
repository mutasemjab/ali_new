@extends('store.layouts.app')
@section('title', 'Account Settings')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Account Settings</h1>
        <p class="page-sub">Update your store details and password</p>
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

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-shop"></i> Store Details</h2>
    </div>
    <div class="panel-card-body">
        <form action="{{ route('store.login.update', $data->id) }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Store Name</label>
                    <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $data->email) }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $data->phone) }}" class="form-control">
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <label class="form-label">New Password (optional)</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@extends('store.layouts.app')
@section('title', 'Coupons')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Coupons</h1>
        <p class="page-sub">Manage discount coupons offered to your clients</p>
    </div>
    <a href="{{ route('store.coupons.create') }}" class="btn-primary-sm">
        <i class="bi bi-ticket-perforated"></i> Add New Coupon
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card mb-3">
    <div class="panel-card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control form-control-sm" placeholder="Search by name...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-search"></i></button>
            </div>
            @if(request('search'))
            <div class="col-auto">
                <a href="{{ route('store.coupons.index') }}" class="btn-outline-sm"><i class="bi bi-x"></i> Clear</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-ticket-perforated"></i> Coupon List</h2>
        <span class="pill pill-info">{{ $coupons->total() }} coupons</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Price After Discount</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th>Starts</th>
                        <th>Ends</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr>
                        <td>{{ $loop->iteration + ($coupons->currentPage() - 1) * $coupons->perPage() }}</td>
                        <td><img src="{{ asset($coupon->photo) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;"></td>
                        <td><span class="fw-semibold">{{ $coupon->name }}</span></td>
                        <td>{{ $coupon->price }}</td>
                        <td>{{ $coupon->price_after_discount }}</td>
                        <td><span class="pill pill-info">{{ ucfirst($coupon->status) }}</span></td>
                        <td>
                            @if($coupon->is_active)
                                <span class="pill pill-success">Active</span>
                            @else
                                <span class="pill pill-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $coupon->start_at->format('m/d/Y') }}</td>
                        <td>{{ $coupon->end_at->format('m/d/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.coupons.edit', $coupon->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete coupon &quot;{{ $coupon->name }}&quot;?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">No coupons added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($coupons->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $coupons->links() }}
    </div>
    @endif
</div>

@endsection

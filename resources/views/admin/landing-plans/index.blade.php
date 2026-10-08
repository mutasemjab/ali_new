@extends('admin.layouts.app')
@section('title', 'Pricing Plans')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Pricing Plans</h1>
        <p class="page-sub">The plan cards shown on the Plans page of the marketing site</p>
    </div>
    <a href="{{ route('admin.landing-plans.create') }}" class="btn-primary-sm">
        <i class="bi bi-credit-card"></i> Add New Plan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-credit-card"></i> Plan List</h2>
        <span class="pill pill-info">{{ $landingPlans->count() }} plans</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Tablets</th>
                        <th>Popular</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($landingPlans as $plan)
                    <tr>
                        <td>{{ $plan->sort_order }}</td>
                        <td><span class="fw-semibold">{{ $plan->name }}</span><div class="text-muted small">{{ $plan->subtitle }}</div></td>
                        <td>{{ $plan->price }}</td>
                        <td>{{ $plan->tablets_included }}</td>
                        <td>
                            @if($plan->is_popular)
                                <span class="pill pill-success">{{ $plan->badge_text ?: 'Popular' }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.landing-plans.edit', $plan->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.landing-plans.destroy', $plan->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this plan?')">
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
                        <td colspan="6" class="text-center text-muted py-4">No plans added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

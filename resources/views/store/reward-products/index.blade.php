@extends('store.layouts.app')
@section('title', 'Rewards')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Rewards</h1>
        <p class="page-sub">Set what clients can redeem their points for — these are separate from your regular product catalog</p>
    </div>
    <a href="{{ route('store.reward-products.create') }}" class="btn-primary-sm">
        <i class="bi bi-trophy"></i> Add New Reward
    </a>
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

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-lightning-charge"></i> Points Earning</h2>
    </div>
    <div class="panel-card-body">
        <form action="{{ route('store.reward-settings.update') }}" method="POST" class="row g-2 align-items-end">
            @csrf @method('PUT')
            <div class="col-auto">
                <label class="form-label small text-muted mb-1">Points earned per visit (once per day)</label>
                <input type="number" min="0" name="points_per_visit"
                    value="{{ old('points_per_visit', auth('store')->user()->points_per_visit) }}"
                    class="form-control form-control-sm" style="width:120px;" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn-outline-sm">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-trophy"></i> Reward List</h2>
        <span class="pill pill-info">{{ $rewardProducts->total() }} rewards</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Points Required</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rewardProducts as $rewardProduct)
                    <tr>
                        <td>{{ $loop->iteration + ($rewardProducts->currentPage() - 1) * $rewardProducts->perPage() }}</td>
                        <td><img src="{{ asset($rewardProduct->image) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;"></td>
                        <td><span class="fw-semibold">{{ $rewardProduct->name }}</span></td>
                        <td><span class="pill pill-info">{{ $rewardProduct->points_required }} points</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.reward-products.edit', $rewardProduct->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.reward-products.destroy', $rewardProduct->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this reward?')">
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
                        <td colspan="5" class="text-center text-muted py-4">No rewards added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($rewardProducts->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $rewardProducts->links() }}
    </div>
    @endif
</div>

@endsection

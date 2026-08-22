@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Platform overview</p>
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

{{-- Stat cards --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Total Stores</div>
                    <div class="fs-3 fw-bold">{{ $totalStores }}</div>
                </div>
                <i class="bi bi-shop fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Active Stores</div>
                    <div class="fs-3 fw-bold">{{ $activeStores }}</div>
                    <div class="text-muted" style="font-size:.72rem;">with a current subscription</div>
                </div>
                <i class="bi bi-check-circle fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Total SMS Sent</div>
                    <div class="fs-3 fw-bold">{{ number_format($totalSmsSent) }}</div>
                </div>
                <i class="bi bi-send fs-2 text-info"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Remaining SMS</div>
                    <div class="fs-3 fw-bold">{{ number_format($remainingSms) }}</div>
                </div>
                <i class="bi bi-chat-dots fs-2 text-warning"></i>
            </div>
        </div>
    </div>
</div>

{{-- Quick add SMS credit --}}
<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-lightning-charge"></i> Add SMS Credit</h2>
    </div>
    <div class="panel-card-body">
        <form action="{{ route('admin.sms.quick-recharge') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Store</label>
                    <select name="store_id" class="form-select" required>
                        <option value="">Select a store</option>
                        @foreach($storesForRecharge as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" min="1" name="quantity" id="quick-sms-quantity" value="{{ old('quantity') }}" class="form-control" placeholder="e.g. 500" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label d-block">Quick Add</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach([500, 1000, 2500, 5000, 10000] as $amount)
                            <button type="button" class="btn-outline-sm quick-sms-btn" data-amount="{{ $amount }}">{{ number_format($amount) }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-plus-circle"></i> Add Credit</button>
            </div>
        </form>
    </div>
</div>

{{-- Store list --}}
<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-shop"></i> Stores</h2>
        <a href="{{ route('admin.stores.index') }}" class="btn-outline-sm">View All</a>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Store Name</th>
                        <th>Email</th>
                        <th>Subscription</th>
                        <th>SMS Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                    @php $latestSub = $store->subscriptions->first(); @endphp
                    <tr>
                        <td><span class="fw-semibold">{{ $store->name }}</span></td>
                        <td>{{ $store->email }}</td>
                        <td>
                            @if(!$latestSub)
                                <span class="pill pill-neutral">No subscription</span>
                            @elseif($latestSub->to_date->isFuture() || $latestSub->to_date->isToday())
                                <span class="pill pill-success">Active until {{ $latestSub->to_date->format('Y-m-d') }}</span>
                            @else
                                <span class="pill pill-danger">Expired {{ $latestSub->to_date->format('Y-m-d') }}</span>
                            @endif
                        </td>
                        <td>{{ $store->total_sms }}</td>
                        <td>
                            @if($store->activate === 1)
                                <span class="pill pill-success">Active</span>
                            @else
                                <span class="pill pill-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.stores.show', $store->id) }}" class="btn-icon-sm" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No stores found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($stores->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $stores->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.querySelectorAll('.quick-sms-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('quick-sms-quantity').value = this.dataset.amount;
    });
});
</script>
@endpush

@endsection

@extends('admin.layouts.app')
@section('title', 'Store Details')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">{{ $store->name }}</h1>
        <p class="page-sub">{{ $store->email }} — {{ $store->phone ?: 'No phone number' }}</p>
    </div>
    <a href="{{ route('admin.stores.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
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

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Clients</div>
                    <div class="fs-3 fw-bold">{{ $clientsCount }}</div>
                </div>
                <i class="bi bi-people fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">SMS Balance</div>
                    <div class="fs-3 fw-bold">{{ $store->total_sms }}</div>
                </div>
                <i class="bi bi-chat-dots fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Status</div>
                    <div class="fs-5 fw-bold">
                        @if($store->activate === 1)
                            <span class="pill pill-success">Active</span>
                        @else
                            <span class="pill pill-danger">Suspended</span>
                        @endif
                    </div>
                </div>
                <form action="{{ route('admin.stores.toggle', $store->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-outline-sm">{{ $store->activate === 1 ? 'Suspend' : 'Activate' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Subscriptions --}}
    <div class="col-lg-6">
        <div class="panel-card mb-3">
            <div class="panel-card-header">
                <h2 class="panel-card-title"><i class="bi bi-calendar-check"></i> Record New Subscription</h2>
            </div>
            <div class="panel-card-body">
                <form action="{{ route('admin.stores.subscriptions.store', $store->id) }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" min="0" name="amount" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_type" class="form-select form-select-sm" required>
                                <option value="cash">Cash</option>
                                <option value="visa">Visa</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Note</label>
                            <input type="text" name="note" class="form-control form-control-sm">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary-sm mt-3"><i class="bi bi-save"></i> Save Subscription</button>
                </form>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title"><i class="bi bi-clock-history"></i> Subscription History</h2>
            </div>
            <div class="panel-card-body p-0">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr><th>From</th><th>To</th><th>Amount</th><th>Payment Method</th></tr>
                        </thead>
                        <tbody>
                            @forelse($store->subscriptions as $sub)
                            <tr>
                                <td>{{ $sub->from_date->format('m/d/Y') }}</td>
                                <td>{{ $sub->to_date->format('m/d/Y') }}</td>
                                <td>{{ $sub->amount }}</td>
                                <td>{{ $sub->payment_type }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No subscriptions recorded</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SMS ledger --}}
    <div class="col-lg-6">
        <div class="panel-card mb-3">
            <div class="panel-card-header">
                <h2 class="panel-card-title"><i class="bi bi-chat-dots"></i> Recharge / Adjust SMS Balance</h2>
            </div>
            <div class="panel-card-body">
                <form action="{{ route('admin.stores.sms.store', $store->id) }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select form-select-sm" required>
                                <option value="recharge">Recharge</option>
                                <option value="refund">Refund</option>
                                <option value="adjustment">Manual Adjustment</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Note</label>
                            <input type="text" name="note" class="form-control form-control-sm">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary-sm mt-3"><i class="bi bi-save"></i> Apply</button>
                </form>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title"><i class="bi bi-clock-history"></i> Balance History</h2>
            </div>
            <div class="panel-card-body p-0">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr><th>Type</th><th>Quantity</th><th>Balance After</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            @forelse($store->smsLedger as $entry)
                            <tr>
                                <td>{{ $entry->type }}</td>
                                <td>{{ $entry->quantity }}</td>
                                <td>{{ $entry->balance_after }}</td>
                                <td>{{ $entry->created_at->format('m/d/Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No balance activity recorded</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

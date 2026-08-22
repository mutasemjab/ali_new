@extends('store.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Welcome back, {{ auth('store')->user()->name }}</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-3 mb-3">
    <div class="col-md-3">
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
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">SMS Balance</div>
                    <div class="fs-3 fw-bold">{{ $smsBalance }}</div>
                </div>
                <i class="bi bi-chat-dots fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">SMS Sent</div>
                    <div class="fs-3 fw-bold">{{ number_format($smsSentCount) }}</div>
                </div>
                <i class="bi bi-send fs-2 text-info"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Subscription Until</div>
                    <div class="fs-5 fw-bold">{{ $activeSubscription?->to_date?->format('Y-m-d') ?? '—' }}</div>
                </div>
                <i class="bi bi-calendar-check fs-2 text-warning"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Categories</div>
                    <div class="fs-3 fw-bold">{{ $categoriesCount }}</div>
                </div>
                <i class="bi bi-folder fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Products</div>
                    <div class="fs-3 fw-bold">{{ $productsCount }}</div>
                </div>
                <i class="bi bi-box-seam fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Ads</div>
                    <div class="fs-3 fw-bold">{{ $adsCount }}</div>
                </div>
                <i class="bi bi-megaphone fs-2 text-secondary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel-card">
            <div class="panel-card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Feedback</div>
                    <div class="fs-3 fw-bold">{{ $feedbackCount }}</div>
                </div>
                <i class="bi bi-chat-square-text fs-2 text-secondary"></i>
            </div>
        </div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-chat-dots"></i> Recent Messages</h2>
        <a href="{{ route('store.messages.index') }}" class="btn-outline-sm">View All</a>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Content</th>
                        <th>Recipients</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentMessages as $message)
                    <tr>
                        <td>{{ \Illuminate\Support\Str::limit($message->content, 40) }}</td>
                        <td>{{ $message->recipients_count }}</td>
                        <td><span class="pill pill-info">{{ $message->status }}</span></td>
                        <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No messages sent yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

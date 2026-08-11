@extends('store.layouts.app')
@section('title', 'Message Details')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Message Details</h1>
        <p class="page-sub">{{ $message->created_at->format('Y-m-d H:i') }}</p>
    </div>
    <a href="{{ route('store.messages.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-chat-text"></i> Message Content</h2>
    </div>
    <div class="panel-card-body">
        <p class="mb-3">{{ $message->content }}</p>
        <div class="d-flex gap-4 small text-muted">
            <span>Recipients: <strong>{{ $message->recipients_count }}</strong></span>
            <span>Sent: <strong>{{ $message->sent_count }}</strong></span>
            <span>Failed: <strong>{{ $message->failed_count }}</strong></span>
            <span>Status: <span class="pill pill-info">{{ $message->status }}</span></span>
        </div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-list-check"></i> Delivery Details</h2>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Sent At</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($message->recipients as $recipient)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $recipient->phone }}</td>
                        <td><span class="pill pill-info">{{ $recipient->status }}</span></td>
                        <td>{{ $recipient->sent_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        <td>{{ $recipient->error ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No recipients</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@extends('store.layouts.app')
@section('title', 'Messages')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Messages</h1>
        <p class="page-sub">History of SMS campaigns sent to clients — current balance: {{ auth('store')->user()->total_sms }} messages</p>
    </div>
    <a href="{{ route('store.messages.create') }}" class="btn-primary-sm">
        <i class="bi bi-send"></i> Send New Message
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-chat-dots"></i> Message History</h2>
        <span class="pill pill-info">{{ $messages->total() }} campaigns</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Content</th>
                        <th>Recipients</th>
                        <th>Sent</th>
                        <th>Failed</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr>
                        <td>{{ $loop->iteration + ($messages->currentPage() - 1) * $messages->perPage() }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($message->content, 40) }}</td>
                        <td>{{ $message->recipients_count }}</td>
                        <td>{{ $message->sent_count }}</td>
                        <td>{{ $message->failed_count }}</td>
                        <td><span class="pill pill-info">{{ $message->status }}</span></td>
                        <td>{{ $message->created_at->format('m/d/Y h:i A') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.messages.show', $message->id) }}" class="btn-icon-sm" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('store.messages.destroy', $message->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this message?')">
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
                        <td colspan="8" class="text-center text-muted py-4">No messages sent yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($messages->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $messages->links() }}
    </div>
    @endif
</div>

@endsection

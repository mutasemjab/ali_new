@extends('store.layouts.app')
@section('title', 'Notifications')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Notifications</h1>
        <p class="page-sub">Manage notifications sent to your clients</p>
    </div>
    <a href="{{ route('store.notifications.create') }}" class="btn-primary-sm">
        <i class="bi bi-bell"></i> Send New Notification
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-bell"></i> Notification List</h2>
        <span class="pill pill-info">{{ $notifications->total() }} notifications</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                    <tr>
                        <td>{{ $loop->iteration + ($notifications->currentPage() - 1) * $notifications->perPage() }}</td>
                        <td><span class="fw-semibold">{{ $notification->title }}</span></td>
                        <td>{{ \Illuminate\Support\Str::limit($notification->body, 80) }}</td>
                        <td>{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('store.notifications.destroy', $notification->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this notification?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No notifications sent yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($notifications->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $notifications->links() }}
    </div>
    @endif
</div>

@endsection

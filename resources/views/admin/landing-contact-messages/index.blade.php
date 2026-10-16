@extends('admin.layouts.app')
@section('title', 'Contact Messages')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Contact Messages</h1>
        <p class="page-sub">Submissions from the Contact Us form on the marketing site</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-envelope-paper"></i> Message List</h2>
        <span class="pill pill-info">{{ $messages->total() }} messages</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Consent</th>
                        <th>Received</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'fw-semibold' }}">
                        <td>{{ $message->name }}</td>
                        <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                        <td>
                            @if($message->phone)
                                <a href="tel:{{ $message->phone }}">{{ $message->phone }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-muted small">{{ \Illuminate\Support\Str::limit($message->message, 60) }}</td>
                        <td class="small">
                            <span class="pill {{ $message->consent_non_marketing ? 'pill-success' : 'pill-danger' }}" title="Non-Marketing">NM</span>
                            <span class="pill {{ $message->consent_marketing ? 'pill-success' : 'pill-info' }}" title="Marketing">M</span>
                            <span class="pill {{ $message->consent_terms ? 'pill-success' : 'pill-danger' }}" title="Terms">T</span>
                        </td>
                        <td class="text-muted small">{{ $message->created_at->format('m/d/Y h:i A') }}</td>
                        <td>
                            @if($message->is_read)
                                <span class="pill pill-success">Read</span>
                            @else
                                <span class="pill pill-danger">New</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <form action="{{ route('admin.landing-contact-messages.toggle', $message->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon-sm" title="{{ $message->is_read ? 'Mark as unread' : 'Mark as read' }}">
                                        <i class="bi {{ $message->is_read ? 'bi-envelope' : 'bi-envelope-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.landing-contact-messages.destroy', $message->id) }}" method="POST" class="d-inline"
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
                        <td colspan="8" class="text-center text-muted py-4">No messages yet</td>
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

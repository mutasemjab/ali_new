@extends('admin.layouts.app')
@section('title', 'Plan Inquiries')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Plan Inquiries</h1>
        <p class="page-sub">Leads submitted from the "Get Started" form on the Plans page</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-inbox"></i> Inquiry List</h2>
        <span class="pill pill-info">{{ $inquiries->total() }} inquiries</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Plan</th>
                        <th>Message</th>
                        <th>Received</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                    <tr class="{{ $inquiry->is_read ? '' : 'fw-semibold' }}">
                        <td>{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->company ?: '—' }}</td>
                        <td><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></td>
                        <td><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></td>
                        <td><span class="pill pill-info">{{ $inquiry->plan_name ?: '—' }}</span></td>
                        <td class="text-muted small">{{ \Illuminate\Support\Str::limit($inquiry->message, 60) ?: '—' }}</td>
                        <td class="text-muted small">{{ $inquiry->created_at->format('m/d/Y h:i A') }}</td>
                        <td>
                            @if($inquiry->is_read)
                                <span class="pill pill-success">Read</span>
                            @else
                                <span class="pill pill-danger">New</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <form action="{{ route('admin.landing-plan-inquiries.toggle', $inquiry->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon-sm" title="{{ $inquiry->is_read ? 'Mark as unread' : 'Mark as read' }}">
                                        <i class="bi {{ $inquiry->is_read ? 'bi-envelope' : 'bi-envelope-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.landing-plan-inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
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
                        <td colspan="9" class="text-center text-muted py-4">No inquiries yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($inquiries->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $inquiries->links() }}
    </div>
    @endif
</div>

@endsection

@extends('store.layouts.app')
@section('title', 'Feedback')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Feedback</h1>
        <p class="page-sub">Client feedback submitted through your public page</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-chat-square-text"></i> Feedback List</h2>
        <span class="pill pill-info">{{ $feedbacks->total() }} feedback</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                    <tr>
                        <td>{{ $loop->iteration + ($feedbacks->currentPage() - 1) * $feedbacks->perPage() }}</td>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->phone }}</td>
                        <td>{{ $feedback->message }}</td>
                        <td>{{ $feedback->created_at->format('m/d/Y h:i A') }}</td>
                        <td>
                            <form action="{{ route('store.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this feedback?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No feedback yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($feedbacks->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $feedbacks->links() }}
    </div>
    @endif
</div>

@endsection

@extends('store.layouts.app')
@section('title', 'Careers')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Careers</h1>
        <p class="page-sub">Job openings shown to clients in the mobile app</p>
    </div>
    <a href="{{ route('store.careers.create') }}" class="btn-primary-sm">
        <i class="bi bi-briefcase"></i> Add New Career
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card mb-3">
    <div class="panel-card-body">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title...">
            <button type="submit" class="btn-outline-sm">Search</button>
        </form>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-briefcase"></i> Career List</h2>
        <span class="pill pill-info">{{ $careers->total() }} careers</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Applicants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($careers as $career)
                    <tr>
                        <td>{{ $loop->iteration + ($careers->currentPage() - 1) * $careers->perPage() }}</td>
                        <td><span class="fw-semibold">{{ $career->title }}</span></td>
                        <td class="text-muted small">{{ \Illuminate\Support\Str::limit($career->description, 80) }}</td>
                        <td>
                            <a href="{{ route('store.careers.applicants', $career->id) }}" class="pill pill-info text-decoration-none">
                                {{ $career->applies_count }} applicant(s)
                            </a>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.careers.applicants', $career->id) }}" class="btn-icon-sm" title="Applicants">
                                    <i class="bi bi-people"></i>
                                </a>
                                <a href="{{ route('store.careers.edit', $career->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.careers.destroy', $career->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this career? All applications will be deleted too.')">
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
                        <td colspan="5" class="text-center text-muted py-4">No careers added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($careers->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $careers->links() }}
    </div>
    @endif
</div>

@endsection

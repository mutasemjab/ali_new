@extends('admin.layouts.app')
@section('title', 'Stores')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Stores</h1>
        <p class="page-sub">Manage the stores subscribed to the platform</p>
    </div>
    <a href="{{ route('admin.stores.create') }}" class="btn-primary-sm">
        <i class="bi bi-shop"></i> Add New Store
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

<div class="panel-card mb-3">
    <div class="panel-card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control form-control-sm" placeholder="Search by name, email, or phone...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-search"></i></button>
            </div>
            @if(request('search'))
            <div class="col-auto">
                <a href="{{ route('admin.stores.index') }}" class="btn-outline-sm"><i class="bi bi-x"></i> Clear</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-shop"></i> Store List</h2>
        <span class="pill pill-info">{{ $stores->total() }} stores</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Store Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>SMS Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                    <tr>
                        <td>{{ $loop->iteration + ($stores->currentPage() - 1) * $stores->perPage() }}</td>
                        <td><span class="fw-semibold">{{ $store->name }}</span></td>
                        <td>{{ $store->email }}</td>
                        <td>{{ $store->phone ?: '—' }}</td>
                        <td>{{ $store->total_sms }}</td>
                        <td>
                            @if($store->activate === 1)
                                <span class="pill pill-success">Active</span>
                            @else
                                <span class="pill pill-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.stores.show', $store->id) }}" class="btn-icon-sm" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.stores.toggle', $store->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon-sm" title="{{ $store->activate === 1 ? 'Suspend' : 'Activate' }}">
                                        <i class="bi bi-power"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete store &quot;{{ $store->name }}&quot;?')">
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
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No stores found
                        </td>
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

@endsection

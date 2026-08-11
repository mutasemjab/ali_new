@extends('store.layouts.app')
@section('title', 'Clients')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Clients</h1>
        <p class="page-sub">Manage your store's client list</p>
    </div>
    <a href="{{ route('store.clients.create') }}" class="btn-primary-sm">
        <i class="bi bi-person-plus"></i> Add New Client
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
                    class="form-control form-control-sm" placeholder="Search by name or phone...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-search"></i></button>
            </div>
            @if(request('search'))
            <div class="col-auto">
                <a href="{{ route('store.clients.index') }}" class="btn-outline-sm"><i class="bi bi-x"></i> Clear</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-people"></i> Client List</h2>
        <span class="pill pill-info">{{ $clients->total() }} clients</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Visits</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>{{ $loop->iteration + ($clients->currentPage() - 1) * $clients->perPage() }}</td>
                        <td><span class="fw-semibold">{{ $client->name }}</span></td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->number_of_visit }}</td>
                        <td>{{ $client->total_points }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.clients.edit', $client->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.clients.destroy', $client->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete client &quot;{{ $client->name }}&quot;?')">
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
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No clients found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($clients->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $clients->links() }}
    </div>
    @endif
</div>

@endsection

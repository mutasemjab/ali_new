@extends('store.layouts.app')
@section('title', 'Locations')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Locations</h1>
        <p class="page-sub">Manage your store's branch locations</p>
    </div>
    <a href="{{ route('store.locations.create') }}" class="btn-primary-sm">
        <i class="bi bi-geo-alt"></i> Add New Location
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-geo-alt"></i> Location List</h2>
        <span class="pill pill-info">{{ $locations->total() }} locations</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Coordinates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                    <tr>
                        <td>{{ $loop->iteration + ($locations->currentPage() - 1) * $locations->perPage() }}</td>
                        <td>
                            @if($location->photo)
                                <img src="{{ asset($location->photo) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                            @else
                                —
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $location->name }}</span></td>
                        <td>{{ $location->address ?? '—' }}</td>
                        <td>{{ $location->phone ?? '—' }}</td>
                        <td>
                            <a href="https://www.google.com/maps?q={{ $location->lat }},{{ $location->lng }}" target="_blank" rel="noopener">
                                {{ $location->lat }}, {{ $location->lng }}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.locations.edit', $location->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.locations.destroy', $location->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete &quot;{{ $location->name }}&quot;?')">
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
                        <td colspan="7" class="text-center text-muted py-4">No locations added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($locations->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $locations->links() }}
    </div>
    @endif
</div>

@endsection

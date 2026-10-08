@extends('admin.layouts.app')
@section('title', 'Feature Highlights')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Feature Highlights</h1>
        <p class="page-sub">The small icon + title rows shown under the Home hero and at the bottom of the Plans page</p>
    </div>
    <a href="{{ route('admin.landing-highlights.create') }}" class="btn-primary-sm">
        <i class="bi bi-stars"></i> Add New Highlight
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@foreach([['label' => 'Home Page — Hero Badges', 'rows' => $homeHighlights], ['label' => 'Plans Page — Footer Cards', 'rows' => $plansHighlights]] as $group)
<div class="panel-card mb-3">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-stars"></i> {{ $group['label'] }}</h2>
        <span class="pill pill-info">{{ $group['rows']->count() }} items</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($group['rows'] as $highlight)
                    <tr>
                        <td>{{ $highlight->sort_order }}</td>
                        <td><i class="bi {{ $highlight->icon }}"></i> <span class="text-muted small">{{ $highlight->icon }}</span></td>
                        <td><span class="fw-semibold">{{ $highlight->title }}</span></td>
                        <td class="text-muted small">{{ $highlight->description }}</td>
                        <td><span class="pill pill-info">{{ $highlight->color }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.landing-highlights.edit', $highlight->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.landing-highlights.destroy', $highlight->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this highlight?')">
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
                        <td colspan="6" class="text-center text-muted py-4">No highlights added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach

@endsection

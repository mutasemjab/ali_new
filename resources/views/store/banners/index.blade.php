@extends('store.layouts.app')
@section('title', 'Banners')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Banners</h1>
        <p class="page-sub">Manage the banners shown on your store's public page</p>
    </div>
    <a href="{{ route('store.banners.create') }}" class="btn-primary-sm">
        <i class="bi bi-image"></i> Add New Banner
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-image"></i> Banner List</h2>
        <span class="pill pill-info">{{ $banners->total() }} banners</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>{{ $loop->iteration + ($banners->currentPage() - 1) * $banners->perPage() }}</td>
                        <td><img src="{{ asset($banner->photo) }}" alt="" style="width:80px;height:40px;object-fit:cover;border-radius:6px;"></td>
                        <td>{{ $banner->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('store.banners.destroy', $banner->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No banners added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($banners->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $banners->links() }}
    </div>
    @endif
</div>

@endsection

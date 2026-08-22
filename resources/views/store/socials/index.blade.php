@extends('store.layouts.app')
@section('title', 'Social Links')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Social Links</h1>
        <p class="page-sub">Manage the social media links shown on your store's public page</p>
    </div>
    <a href="{{ route('store.socials.create') }}" class="btn-primary-sm">
        <i class="bi bi-share"></i> Add New Social Link
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-share"></i> Social Link List</h2>
        <span class="pill pill-info">{{ $socials->total() }} links</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($socials as $social)
                    <tr>
                        <td>{{ $loop->iteration + ($socials->currentPage() - 1) * $socials->perPage() }}</td>
                        <td><img src="{{ asset($social->photo) }}" alt="" style="width:32px;height:32px;object-fit:cover;border-radius:6px;"></td>
                        <td><span class="fw-semibold">{{ $social->name }}</span></td>
                        <td><a href="{{ $social->link }}" target="_blank" rel="noopener">{{ $social->link }}</a></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.socials.edit', $social->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.socials.destroy', $social->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete &quot;{{ $social->name }}&quot;?')">
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
                        <td colspan="5" class="text-center text-muted py-4">No social links added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($socials->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $socials->links() }}
    </div>
    @endif
</div>

@endsection

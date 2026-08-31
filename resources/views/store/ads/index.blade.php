@extends('store.layouts.app')
@section('title', 'Ads')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Ads</h1>
        <p class="page-sub">Create an ad and get a link to send to your clients via SMS</p>
    </div>
    <a href="{{ route('store.ads.create') }}" class="btn-primary-sm">
        <i class="bi bi-megaphone"></i> Create New Ad
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-megaphone"></i> Ad List</h2>
        <span class="pill pill-info">{{ $ads->total() }} ads</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Content</th>
                        <th>Public Link</th>
                        <th>Expires</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ads as $ad)
                    <tr>
                        <td>{{ $loop->iteration + ($ads->currentPage() - 1) * $ads->perPage() }}</td>
                        <td><span class="pill pill-info">{{ $ad->type === 'image' ? 'Image' : 'Products' }}</span></td>
                        <td>
                            @if($ad->type === 'image')
                                <div class="d-flex align-items-center gap-2">
                                    @if($ad->cover_image)
                                        <img src="{{ asset($ad->cover_image) }}" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:6px;">
                                    @endif
                                    @if($ad->images->count() > 1)
                                        <span class="pill pill-info">+{{ $ad->images->count() }} images</span>
                                    @endif
                                </div>
                            @else
                                {{ $ad->products->count() }} products
                            @endif
                        </td>
                        <td>
                            <input type="text" readonly value="{{ $ad->public_url }}" class="form-control form-control-sm" style="max-width:260px;" onclick="this.select()">
                        </td>
                        <td>
                            @if(!$ad->expires_at)
                                <span class="pill pill-info">Never</span>
                            @elseif($ad->is_expired)
                                <span class="pill pill-danger">Expired {{ $ad->expires_at->format('m/d/Y h:i A') }}</span>
                            @else
                                <span class="pill pill-success">{{ $ad->expires_at->format('m/d/Y h:i A') }}</span>
                            @endif
                        </td>
                        <td>{{ $ad->created_at->format('m/d/Y h:i A') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.ads.sms.create', $ad->id) }}" class="btn-icon-sm" title="Send Message">
                                    <i class="bi bi-send"></i>
                                </a>
                                <a href="{{ route('store.ads.edit', $ad->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.ads.destroy', $ad->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this ad?')">
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
                        <td colspan="7" class="text-center text-muted py-4">No ads yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($ads->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $ads->links() }}
    </div>
    @endif
</div>

@endsection

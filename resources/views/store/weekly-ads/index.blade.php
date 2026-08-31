@extends('store.layouts.app')
@section('title', 'Weekly Ads')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Weekly Ads</h1>
        <p class="page-sub">Manage weekly promotional ads with a start and end date</p>
    </div>
    <a href="{{ route('store.weekly-ads.create') }}" class="btn-primary-sm">
        <i class="bi bi-calendar-week"></i> Add New Weekly Ad
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-calendar-week"></i> Weekly Ad List</h2>
        <span class="pill pill-info">{{ $weeklyAds->total() }} weekly ads</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Starts</th>
                        <th>Ends</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($weeklyAds as $weeklyAd)
                    <tr>
                        <td>{{ $loop->iteration + ($weeklyAds->currentPage() - 1) * $weeklyAds->perPage() }}</td>
                        <td><img src="{{ asset($weeklyAd->photo) }}" alt="" style="width:80px;height:40px;object-fit:cover;border-radius:6px;"></td>
                        <td>{{ $weeklyAd->start_at->format('m/d/Y') }}</td>
                        <td>{{ $weeklyAd->end_at->format('m/d/Y') }}</td>
                        <td>
                            @if($weeklyAd->is_active)
                                <span class="pill pill-success">Active</span>
                            @else
                                <span class="pill pill-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.weekly-ads.sms.create', $weeklyAd->id) }}" class="btn-icon-sm" title="Send SMS">
                                    <i class="bi bi-send"></i>
                                </a>
                                <a href="{{ route('store.weekly-ads.edit', $weeklyAd->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.weekly-ads.destroy', $weeklyAd->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this weekly ad?')">
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
                        <td colspan="6" class="text-center text-muted py-4">No weekly ads added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($weeklyAds->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $weeklyAds->links() }}
    </div>
    @endif
</div>

@endsection

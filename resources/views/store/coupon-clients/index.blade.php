@extends('store.layouts.app')
@section('title', 'Coupon Clips')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Coupon Clips</h1>
        <p class="page-sub">See which clients clipped which coupons</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-ticket-perforated"></i> Clip List</h2>
        <span class="pill pill-info">{{ $couponClients->total() }} clips</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Coupon</th>
                        <th>Status</th>
                        <th>Clipped At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($couponClients as $couponClient)
                    <tr>
                        <td>{{ $loop->iteration + ($couponClients->currentPage() - 1) * $couponClients->perPage() }}</td>
                        <td>{{ $couponClient->client->name ?? '—' }}</td>
                        <td>{{ $couponClient->coupon->name ?? '—' }}</td>
                        <td><span class="pill pill-info">{{ ucfirst($couponClient->status) }}</span></td>
                        <td>{{ optional($couponClient->clipped_at)->format('m/d/Y h:i A') ?? '—' }}</td>
                        <td>
                            <form action="{{ route('store.coupon-clients.destroy', $couponClient->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to revoke this clip?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-delete" title="Revoke">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No clips yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($couponClients->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $couponClients->links() }}
    </div>
    @endif
</div>

@endsection

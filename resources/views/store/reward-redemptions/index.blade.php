@extends('store.layouts.app')
@section('title', 'Reward Redemptions')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Reward Redemptions</h1>
        <p class="page-sub">See which clients redeemed which rewards, and how many points it cost them</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-trophy"></i> Redemption List</h2>
        <span class="pill pill-info">{{ $rewardRedemptions->total() }} redemptions</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Reward</th>
                        <th>Points Spent</th>
                        <th>Redeemed At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rewardRedemptions as $rewardRedemption)
                    <tr>
                        <td>{{ $loop->iteration + ($rewardRedemptions->currentPage() - 1) * $rewardRedemptions->perPage() }}</td>
                        <td>{{ $rewardRedemption->client->name ?? '—' }}</td>
                        <td>{{ $rewardRedemption->rewardProduct->name ?? '—' }}</td>
                        <td><span class="pill pill-info">{{ $rewardRedemption->points_spent }} points</span></td>
                        <td>{{ $rewardRedemption->created_at->format('m/d/Y h:i A') }}</td>
                        <td>
                            <form action="{{ route('store.reward-redemptions.destroy', $rewardRedemption->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this redemption record? This does not refund the points.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No redemptions yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($rewardRedemptions->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $rewardRedemptions->links() }}
    </div>
    @endif
</div>

@endsection

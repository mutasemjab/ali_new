@extends('store.layouts.app')
@section('title', 'QR Codes')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">QR Codes</h1>
        <p class="page-sub">Generate QR codes that link to any page or resource</p>
    </div>
    <a href="{{ route('store.qrs.create') }}" class="btn-primary-sm">
        <i class="bi bi-qr-code"></i> Generate New QR Code
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-qr-code"></i> QR Code List</h2>
        <span class="pill pill-info">{{ $qrs->total() }} QR codes</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>QR Code</th>
                        <th>Link</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($qrs as $qr)
                    <tr>
                        <td>{{ $loop->iteration + ($qrs->currentPage() - 1) * $qrs->perPage() }}</td>
                        <td><img src="{{ asset($qr->photo) }}" alt="" style="width:50px;height:50px;object-fit:contain;background:#fff;border-radius:6px;"></td>
                        <td><a href="{{ $qr->link }}" target="_blank" rel="noopener">{{ $qr->link }}</a></td>
                        <td>{{ $qr->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('store.qrs.destroy', $qr->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this QR code?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No QR codes generated yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($qrs->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $qrs->links() }}
    </div>
    @endif
</div>

@endsection

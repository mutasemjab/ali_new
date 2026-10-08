@extends('admin.layouts.app')
@section('title', 'How It Works Steps')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">How It Works Steps</h1>
        <p class="page-sub">The numbered steps shown on the Home page of the marketing site</p>
    </div>
    <a href="{{ route('admin.landing-steps.create') }}" class="btn-primary-sm">
        <i class="bi bi-list-ol"></i> Add New Step
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-list-ol"></i> Step List</h2>
        <span class="pill pill-info">{{ $landingSteps->count() }} steps</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Color</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($landingSteps as $step)
                    <tr>
                        <td>{{ $step->number }}</td>
                        <td>
                            @if($step->image)
                                <img src="{{ asset($step->image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $step->title }}</span></td>
                        <td><span class="pill pill-info">{{ $step->color }}</span></td>
                        <td>{{ $step->sort_order }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.landing-steps.edit', $step->id) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.landing-steps.destroy', $step->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this step?')">
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
                        <td colspan="6" class="text-center text-muted py-4">No steps added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

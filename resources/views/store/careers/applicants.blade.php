@extends('store.layouts.app')
@section('title', 'Applicants')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Applicants</h1>
        <p class="page-sub">{{ $career->title }}</p>
    </div>
    <a href="{{ route('store.careers.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to Careers
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-people"></i> Applications</h2>
        <span class="pill pill-info">{{ $applications->count() }} applicant(s)</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Phone</th>
                        @foreach($reportSpecifications as $spec)
                        <th>{{ $spec->name }}</th>
                        @endforeach
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="fw-semibold">{{ $application['client']->name }}</span></td>
                        <td>{{ $application['client']->phone }}</td>
                        @foreach($reportSpecifications as $spec)
                        <td>
                            @php $answer = $application['answers']->get($spec->id); @endphp
                            @if(!$answer || !$answer->value)
                                <span class="text-muted">-</span>
                            @elseif($spec->type == \App\Models\CareerSpecification::TYPE_FILE)
                                <a href="{{ asset($answer->value) }}" target="_blank">View File</a>
                            @else
                                {{ \Illuminate\Support\Str::limit($answer->value, 40) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="text-muted small">{{ optional($application['submitted_at'])->format('m/d/Y h:i A') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.careers.applicants.show', [$career->id, $application['client']->id]) }}" class="btn-icon-sm" title="View Full Application">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('store.careers.applicants.destroy', [$career->id, $application['client']->id]) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this application?')">
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
                        <td colspan="{{ 5 + $reportSpecifications->count() }}" class="text-center text-muted py-4">No applications yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

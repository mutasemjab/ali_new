@extends('store.layouts.app')
@section('title', 'Application Details')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Application Details</h1>
        <p class="page-sub">{{ $client->name }} — {{ $career->title }}</p>
    </div>
    <a href="{{ route('store.careers.applicants', $career->id) }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to Applicants
    </a>
</div>

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-person"></i> Client</h2>
    </div>
    <div class="panel-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="text-muted small">Name</div>
                <div class="fw-semibold">{{ $client->name }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Phone</div>
                <div class="fw-semibold">{{ $client->phone }}</div>
            </div>
        </div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-list-check"></i> Answers</h2>
    </div>
    <div class="panel-card-body">
        @forelse($career->specifications as $spec)
            @php $answer = $answers->get($spec->id); @endphp
            <div class="row g-3 py-2 border-bottom">
                <div class="col-md-4 text-muted">{{ $spec->name }}</div>
                <div class="col-md-8">
                    @if(!$answer || !$answer->value)
                        <span class="text-muted">No answer</span>
                    @elseif($spec->type == \App\Models\CareerSpecification::TYPE_FILE)
                        <a href="{{ asset($answer->value) }}" target="_blank"><i class="bi bi-paperclip"></i> View File</a>
                    @else
                        {{ $answer->value }}
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">This career has no application fields.</p>
        @endforelse
    </div>
</div>

@endsection

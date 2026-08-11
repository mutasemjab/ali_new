@extends('store.layouts.app')
@section('title', 'Send New Message')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Send New Message</h1>
        <p class="page-sub">This message will be sent to all of your store's clients ({{ $clientsCount }} clients)</p>
    </div>
    <a href="{{ route('store.messages.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('store.messages.store') }}" method="POST">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-chat-text"></i> Message Content</h2>
    </div>
    <div class="panel-card-body">
        <div class="mb-2 small text-muted">
            Current balance: <strong>{{ auth('store')->user()->total_sms }}</strong> messages —
            Recipients: <strong>{{ $clientsCount }}</strong>
        </div>
        <textarea name="content" rows="5" maxlength="600" class="form-control" placeholder="Write your message here..." required>{{ old('content') }}</textarea>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm" {{ $clientsCount === 0 ? 'disabled' : '' }}>
        <i class="bi bi-send"></i> Send Campaign
    </button>
    <a href="{{ route('store.messages.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@endsection

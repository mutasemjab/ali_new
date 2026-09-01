@extends('store.layouts.app')
@section('title', 'Send Ad SMS')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Send Ad via SMS</h1>
        <p class="page-sub">Choose who receives this message</p>
    </div>
    <a href="{{ route('store.ads.index') }}" class="btn-outline-sm">
        <i class="bi bi-arrow-right"></i> Back to List
    </a>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card mb-3">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-chat-square-text"></i> Message Preview</h2>
    </div>
    <div class="panel-card-body">
        @if($ad->type === 'image' && $ad->cover_image)
            <img src="{{ asset($ad->cover_image) }}" alt="" style="width:120px;height:60px;object-fit:cover;border-radius:6px;" class="mb-2">
        @endif
        @php
            $preview = $ad->store->name . "\n\nTap to view now! " . $ad->public_url;
            if ($ad->start_at && $ad->expires_at) {
                $preview .= "\n" . $ad->start_at->format('m/d/Y') . ' TO ' . $ad->expires_at->format('m/d/Y');
            } elseif ($ad->expires_at) {
                $preview .= "\nOffer ends " . $ad->expires_at->format('m/d/Y h:i A');
            } elseif ($ad->start_at) {
                $preview .= "\nStarts " . $ad->start_at->format('m/d/Y h:i A');
            }
            $preview .= "\nText STOP to opt-out.";
        @endphp
        <pre class="mb-0" style="white-space:pre-wrap;font-family:inherit;background:var(--bg,#f8fafc);padding:12px;border-radius:8px;">{{ $preview }}</pre>
    </div>
</div>

<form action="{{ route('store.ads.sms.send', $ad->id) }}" method="POST">
@csrf

<div class="panel-card">
    <div class="panel-card-header">
        <h2 class="panel-card-title"><i class="bi bi-people"></i> Recipients</h2>
    </div>
    <div class="panel-card-body">
        <div class="form-check mb-2">
            <input type="radio" name="recipients" value="all" id="recipients_all" class="form-check-input recipients-radio" checked>
            <label class="form-check-label" for="recipients_all">All clients ({{ $clients->count() }})</label>
        </div>
        <div class="form-check mb-3">
            <input type="radio" name="recipients" value="selected" id="recipients_selected" class="form-check-input recipients-radio">
            <label class="form-check-label" for="recipients_selected">Select specific clients</label>
        </div>

        <div id="client-picker" style="display:none;">
            @if($clients->isEmpty())
                <p class="text-muted small mb-0">No clients added yet.</p>
            @else
            <div class="row g-2" style="max-height:320px;overflow-y:auto;">
                @foreach($clients as $client)
                <div class="col-md-4">
                    <label class="d-flex align-items-center gap-2 p-2 rounded border">
                        <input type="checkbox" name="client_ids[]" value="{{ $client->id }}">
                        <span>{{ $client->name }} — {{ $client->phone }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-send"></i> Send SMS</button>
    <a href="{{ route('store.ads.index') }}" class="btn-outline-sm">Cancel</a>
</div>

</form>

@push('scripts')
<script>
function toggleClientPicker() {
    var isSelected = document.getElementById('recipients_selected').checked;
    document.getElementById('client-picker').style.display = isSelected ? '' : 'none';
}
document.querySelectorAll('.recipients-radio').forEach(function (r) {
    r.addEventListener('change', toggleClientPicker);
});
toggleClientPicker();
</script>
@endpush

@endsection

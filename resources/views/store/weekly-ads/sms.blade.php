@extends('store.layouts.app')
@section('title', 'Send Weekly Ad SMS')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Send Weekly Ad via SMS</h1>
        <p class="page-sub">Choose who receives this message</p>
    </div>
    <a href="{{ route('store.weekly-ads.index') }}" class="btn-outline-sm">
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
        <img src="{{ asset($weeklyAd->photo) }}" alt="" style="width:120px;height:60px;object-fit:cover;border-radius:6px;" class="mb-2">
        <pre class="mb-0" style="white-space:pre-wrap;font-family:inherit;background:var(--bg,#f8fafc);padding:12px;border-radius:8px;">{{ $weeklyAd->store->name }}
WEEKLY AD
{{ $weeklyAd->start_at->format('m/d/Y') }} TO {{ $weeklyAd->end_at->format('m/d/Y') }}

Tap to view specials! {{ $weeklyAd->public_url }}
Text STOP to opt-out.</pre>
    </div>
</div>

<form action="{{ route('store.weekly-ads.sms.send', $weeklyAd->id) }}" method="POST">
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
            <input type="text" id="client-phone-search" class="form-control form-control-sm mb-2" placeholder="Search by phone...">
            <div class="row g-2" id="client-list" style="max-height:320px;overflow-y:auto;">
                @foreach($clients as $client)
                <div class="col-md-4 client-row" data-phone="{{ $client->phone }}">
                    <label class="d-flex align-items-center gap-2 p-2 rounded border">
                        <input type="checkbox" name="client_ids[]" value="{{ $client->id }}">
                        <span>{{ $client->name }} — {{ $client->phone }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <p class="text-muted small mb-0 mt-2 d-none" id="client-search-empty">No clients match this phone number.</p>
            @endif
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pb-4">
    <button type="submit" class="btn-primary-sm"><i class="bi bi-send"></i> Send SMS</button>
    <a href="{{ route('store.weekly-ads.index') }}" class="btn-outline-sm">Cancel</a>
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

var phoneSearch = document.getElementById('client-phone-search');
if (phoneSearch) {
    phoneSearch.addEventListener('input', function () {
        var term = phoneSearch.value.replace(/\s+/g, '').toLowerCase();
        var rows = document.querySelectorAll('#client-list .client-row');
        var visibleCount = 0;

        rows.forEach(function (row) {
            var phone = (row.dataset.phone || '').replace(/\s+/g, '').toLowerCase();
            var matches = phone.indexOf(term) !== -1;
            row.classList.toggle('d-none', !matches);
            if (matches) visibleCount++;
        });

        document.getElementById('client-search-empty').classList.toggle('d-none', visibleCount !== 0);
    });
}
</script>
@endpush

@endsection

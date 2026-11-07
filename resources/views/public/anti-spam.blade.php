@extends('public.layouts.app')

@section('title', 'Anti-Spam Policy — ' . $store->name)

@section('content')

<div class="surface-card reveal">
    <div class="section-title">
        <i class="bi bi-envelope-slash me-1"></i> Anti-Spam Policy
    </div>

<div class="section-sub">
    How we keep our messages relevant and respectful
</div>

<div style="white-space: pre-line; line-height: 1.9; color: var(--ink);">
    {{ $antiSpamPolicy ?: 'No anti-spam policy has been added yet.' }}
</div>

</div>

@include('public.partials.store-links')

@endsection

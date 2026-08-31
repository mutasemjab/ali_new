@extends('public.layouts.app')

@section('title', 'Privacy Policy — ' . $store->name)

@section('content')

<div class="surface-card reveal">
    <div class="section-title">
        <i class="bi bi-shield-lock me-1"></i> Privacy Policy
    </div>

<div class="section-sub">
    How we handle your data
</div>

<div style="white-space: pre-line; line-height: 1.9; color: var(--ink);">
    {{ $privacyPolicy ?: 'No privacy policy has been added yet.' }}
</div>

</div>

@include('public.partials.store-links')

@endsection

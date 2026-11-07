@extends('public.layouts.app')

@section('title', 'Terms of Service — ' . $store->name)

@section('content')

<div class="surface-card reveal">
    <div class="section-title">
        <i class="bi bi-file-earmark-text me-1"></i> Terms of Service
    </div>

<div class="section-sub">
    The rules for using our service
</div>

<div style="white-space: pre-line; line-height: 1.9; color: var(--ink);">
    {{ $termsOfService ?: 'No terms of service have been added yet.' }}
</div>

</div>

@include('public.partials.store-links')

@endsection

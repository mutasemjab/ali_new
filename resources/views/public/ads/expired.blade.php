@extends('public.layouts.app')

@php $store = $ad->store; @endphp

@section('title', $store->name)

@section('content')

<div class="surface-card reveal text-center" style="padding:48px 24px;">
    <div style="width:76px;height:76px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;background:linear-gradient(135deg, var(--primary-1), var(--primary-2)); animation: pulse 2.2s ease-in-out infinite;">
        <i class="bi bi-hourglass-bottom" style="font-size:2rem;color:#fff;"></i>
    </div>
  @if($reason === 'not_yet_started')
    <h1 class="section-title mb-2">This Link Is Not Available Yet</h1>
    <p class="text-muted mb-0">This ad from {{ $store->name }} will be available starting from {{ $ad->start_at->format('m/d/Y h:i A') }}.</p>
@else
    <h1 class="section-title mb-2">This Link Has Expired</h1>
    <p class="text-muted mb-0">This ad from {{ $store->name }} is no longer available.</p>
@endif
</div>

@include('public.partials.store-links')

<style>
    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(99,102,241,.35); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 14px rgba(99,102,241,0); }
    }
</style>

@endsection

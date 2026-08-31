@extends('public.layouts.app')

@php $store = $weeklyAd->store; @endphp

@section('title', $store->name . ' — Weekly Ad')

@section('content')

<div class="surface-card reveal" style="padding:10px;">
    <img src="{{ asset($weeklyAd->photo) }}" alt="" style="width:100%; display:block; border-radius:16px;">
</div>

<div class="text-center mt-3 mb-1" style="color:var(--muted); font-weight:600; font-size:.9rem;">
    {{ $weeklyAd->start_at->format('m/d/Y') }} — {{ $weeklyAd->end_at->format('m/d/Y') }}
</div>

@include('public.partials.store-links')

<button type="button" class="share-btn mt-3" data-share-url="{{ $weeklyAd->public_url }}" data-share-title="{{ $store->name }}">
    <i class="bi bi-share-fill"></i>
    <span class="share-btn-label">مشاركة الآن</span>
</button>

@endsection

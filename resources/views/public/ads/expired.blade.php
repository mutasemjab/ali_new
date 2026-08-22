@extends('public.layouts.app')

@php $store = $ad->store; @endphp

@section('title', $store->name)

@section('content')

<div class="text-center py-5">
    <i class="bi bi-hourglass-bottom" style="font-size:3rem;color:#94a3b8;"></i>
    <h1 class="h5 fw-bold mt-3 mb-2">انتهت صلاحية هذا الرابط</h1>
    <p class="text-muted">هذا الإعلان من {{ $store->name }} لم يعد متاحاً.</p>
</div>

@endsection

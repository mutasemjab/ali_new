@extends('public.layouts.app')
@section('title', 'سياسة الخصوصية — ' . $store->name)
@section('page-tagline', 'سياسة الخصوصية')

@section('content')

<div class="surface-card reveal">
    <div class="section-title"><i class="bi bi-shield-lock me-1"></i> سياسة الخصوصية</div>
    <div class="section-sub">كيف نتعامل مع بياناتك</div>

    <div style="white-space: pre-line; line-height: 1.9; color: var(--ink);">
        {{ $store->privacy_policy ?: 'لم يتم إضافة سياسة خصوصية بعد.' }}
    </div>
</div>

@endsection

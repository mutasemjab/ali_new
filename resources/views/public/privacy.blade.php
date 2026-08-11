@extends('public.layouts.app')
@section('title', 'سياسة الخصوصية — ' . $store->name)

@section('content')

<h1 class="h4 fw-bold mb-3">سياسة الخصوصية</h1>
<p class="text-muted small mb-4">{{ $store->name }}</p>

<div class="bg-white rounded-3 p-3 shadow-sm" style="white-space: pre-line;">
    {{ $store->privacy_policy ?: 'لم يتم إضافة سياسة خصوصية بعد.' }}
</div>

@endsection

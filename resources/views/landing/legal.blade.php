@extends('landing.layouts.app')
@section('title', $title)

@push('styles')
<style>
    .lp-legal-body { white-space: pre-wrap; line-height: 1.7; color: var(--ink); font-size: .95rem; }
</style>
@endpush

@section('content')

<section class="lp-section">
    <div class="container-xl" style="max-width:760px;">
        <h1 class="lp-h1 text-center">{{ $title }}</h1>

        @if($content)
            <div class="lp-legal-body mt-4">{{ $content }}</div>
        @else
            <p class="lp-lead mx-auto text-center" style="max-width:none;">This page hasn't been written yet.</p>
        @endif
    </div>
</section>

@endsection

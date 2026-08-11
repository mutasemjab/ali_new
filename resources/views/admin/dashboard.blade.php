@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Welcome back</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
@endsection

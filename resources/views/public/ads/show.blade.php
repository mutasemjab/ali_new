@extends('public.layouts.app')

@php $store = $ad->store; @endphp

@section('title', $store->name)

@section('content')

<h1 class="h5 fw-bold mb-3 text-center">{{ $store->name }}</h1>

@if($ad->type === 'image')
    <div class="bg-white rounded-3 p-2 shadow-sm text-center">
        <img src="{{ asset($ad->image) }}" alt="" class="img-fluid rounded-2">
    </div>
@else
    <div class="d-flex flex-column gap-3">
        @forelse($ad->products as $product)
        <div class="bg-white rounded-3 p-2 shadow-sm d-flex align-items-center gap-3">
            <img src="{{ asset($product->image) }}" alt="" class="rounded-2 flex-shrink-0" style="width:110px;height:110px;object-fit:cover;">
            <div class="flex-grow-1">
                <div class="fw-semibold mb-1">{{ $product->name }}</div>
                <div class="fs-5">
                    @if($product->has_active_discount)
                        <span class="text-decoration-line-through text-muted small">${{ $product->price_usd }}</span>
                        <span class="fw-bold text-success">${{ $product->final_price }}</span>
                    @else
                        <span class="fw-bold">${{ $product->price_usd }}</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted text-center">لا يوجد منتجات في هذا الإعلان</p>
        @endforelse
    </div>
@endif

@endsection

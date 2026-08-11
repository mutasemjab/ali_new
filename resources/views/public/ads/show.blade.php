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
    <div class="row g-3">
        @forelse($ad->products as $product)
        <div class="col-6">
            <div class="bg-white rounded-3 p-2 shadow-sm h-100">
                <img src="{{ asset($product->image) }}" alt="" class="img-fluid rounded-2 mb-2" style="aspect-ratio:1;object-fit:cover;width:100%;">
                <div class="fw-semibold small">{{ $product->name }}</div>
                <div>
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

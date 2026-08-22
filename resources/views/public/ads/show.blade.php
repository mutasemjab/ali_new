@extends('public.layouts.app')

@php $store = $ad->store; @endphp

@section('title', $store->name)

@section('content')

@if($ad->type === 'image')
    <div class="surface-card reveal" style="padding:10px;">
        <img src="{{ asset($ad->image) }}" alt="" class="img-fluid" style="border-radius:16px; width:100%; display:block;">
    </div>
@else
    @forelse($ad->products as $product)
        @if($loop->first)
        <div class="surface-card" style="padding:6px 18px;">
        @endif

            <div class="product-row reveal" style="transition-delay:{{ min($loop->index * 70, 500) }}ms;">
                <img src="{{ asset($product->image) }}" alt="" class="rounded-3 flex-shrink-0" style="width:96px;height:96px;object-fit:cover;">
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

        @if($loop->last)
        </div>
        @endif
    @empty
        <div class="surface-card reveal text-center py-5">
            <i class="bi bi-inboxes" style="font-size:2.5rem;color:var(--muted);"></i>
            <p class="text-muted mt-3 mb-0">لا يوجد منتجات في هذا الإعلان</p>
        </div>
    @endforelse
@endif

@endsection

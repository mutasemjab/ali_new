@php
    $checkedIds = array_map('intval', (array) $checked);
    $orderIds = old('products_order') !== null
        ? array_values(array_filter(array_map('intval', explode(',', old('products_order')))))
        : $checkedIds;
@endphp

@if($products->isEmpty())
    <p class="text-muted small mb-0">No products added yet. <a href="{{ route('store.products.create') }}">Add a product</a></p>
@else
<p class="text-muted small">The numbers show the order products will appear on the ad link — click them in the order you want.</p>
<input type="hidden" name="products_order" id="products-order" value="{{ implode(',', $orderIds) }}">
<div class="row g-2" id="product-picker">
    @foreach($products as $product)
    <div class="col-md-4">
        <label class="d-flex align-items-center gap-2 p-2 rounded border">
            <input type="checkbox" class="product-check" name="products[]" value="{{ $product->id }}"
                   {{ in_array($product->id, $checkedIds) ? 'checked' : '' }}>
            <img src="{{ asset($product->image) }}" alt="" style="width:32px;height:32px;object-fit:cover;border-radius:6px;">
            <span class="flex-grow-1">{{ $product->name }} — {{ $product->price_usd }}</span>
            <span class="order-badge badge bg-primary rounded-pill d-none"></span>
        </label>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
(function () {
    var picker = document.getElementById('product-picker');
    var orderInput = document.getElementById('products-order');
    if (!picker || !orderInput) return;

    var checks = picker.querySelectorAll('.product-check');
    var order = orderInput.value ? orderInput.value.split(',').filter(Boolean) : [];

    var checkedNow = {};
    checks.forEach(function (cb) { if (cb.checked) checkedNow[cb.value] = true; });
    order = order.filter(function (id) { return checkedNow[id]; });
    checks.forEach(function (cb) {
        if (cb.checked && order.indexOf(cb.value) === -1) order.push(cb.value);
    });

    function render() {
        checks.forEach(function (cb) {
            var badge = cb.closest('label').querySelector('.order-badge');
            var idx = order.indexOf(cb.value);
            badge.textContent = idx > -1 ? idx + 1 : '';
            badge.classList.toggle('d-none', idx === -1);
        });
        orderInput.value = order.join(',');
    }

    checks.forEach(function (cb) {
        cb.addEventListener('change', function () {
            order = order.filter(function (id) { return id !== cb.value; });
            if (cb.checked) order.push(cb.value);
            render();
        });
    });

    render();
})();
</script>
@endpush
@endif

@extends('store.layouts.app')
@section('title', 'Products')

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="page-title">Products</h1>
        <p class="page-sub">Manage your store's products, prices, and discounts</p>
    </div>
    <a href="{{ route('store.products.create') }}" class="btn-primary-sm">
        <i class="bi bi-box-seam"></i> Add New Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="panel-card mb-3">
    <div class="panel-card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control form-control-sm" placeholder="Search by name...">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label small text-muted mb-1">Category</label>
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>All</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1">Expiring within (days)</label>
                <input type="number" min="0" name="expires_in_days" value="{{ request('expires_in_days') }}"
                    class="form-control form-control-sm" placeholder="e.g. 7">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn-primary-sm"><i class="bi bi-search"></i></button>
            </div>
            @if(request()->hasAny(['search', 'category_id', 'status', 'expires_in_days']))
            <div class="col-auto">
                <a href="{{ route('store.products.index') }}" class="btn-outline-sm"><i class="bi bi-x"></i> Clear</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header d-flex align-items-center justify-content-between">
        <h2 class="panel-card-title"><i class="bi bi-box-seam"></i> Product List</h2>
        <span class="pill pill-info">{{ $products->total() }} products</span>
    </div>
    <div class="panel-card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price Before</th>
                        <th>Price After</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <form action="{{ route('store.products.reorder', $product->id) }}" method="POST">
                                @csrf
                                <input type="number" name="sort_order" value="{{ $product->sort_order }}" min="1"
                                    class="form-control form-control-sm" style="width:70px;"
                                    onchange="this.form.submit()">
                            </form>
                        </td>
                        <td><img src="{{ asset($product->image) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;"></td>
                        <td><span class="fw-semibold">{{ $product->name }}</span></td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>
                            @if($product->has_active_discount)
                                <span class="text-decoration-line-through text-muted">{{ $product->price_usd }}</span>
                            @else
                                {{ $product->price_usd }}
                            @endif
                        </td>
                        <td>
                            @if($product->has_active_discount)
                                <span class="fw-semibold text-success">{{ $product->final_price }}</span>
                            @else
                                {{ $product->price_usd }}
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('store.products.toggle', $product->id) }}" method="POST">
                                @csrf
                                <div class="form-check form-switch mb-0">
                                    <input type="checkbox" class="form-check-input" role="switch"
                                        {{ $product->active ? 'checked' : '' }} onchange="this.form.submit()">
                                </div>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('store.products.edit', $product->id) }}?return_to={{ urlencode(request()->fullUrl()) }}" class="btn-icon-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('store.products.destroy', $product->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete product &quot;{{ $product->name }}&quot;?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon-sm btn-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No products added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="panel-card-body border-top pt-3">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection

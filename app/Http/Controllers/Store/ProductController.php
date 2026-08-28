<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->when($request->category_id, fn ($q, $categoryId) => $q->where('category_id', $categoryId))
            ->when($request->status === 'active', fn ($q) => $q->where('active', true))
            ->when($request->status === 'inactive', fn ($q) => $q->where('active', false))
            ->when($request->expires_in_days, function ($q, $days) {
                $q->whereNotNull('discount_to')
                    ->whereDate('discount_to', '>=', now()->toDateString())
                    ->whereDate('discount_to', '<=', now()->addDays((int) $days)->toDateString());
            })
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('store.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('store.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'image' => 'required|image|max:2048',
            'price_usd' => 'required|numeric|min:0',
            'price_after' => 'nullable|numeric|min:0|lt:price_usd',
            'discount_from' => 'nullable|date|required_with:discount_to',
            'discount_to' => 'nullable|date|after_or_equal:discount_from|required_with:discount_from',
        ]);

        $filename = uploadImage('assets/uploads/products', $request->file('image'));

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image' => 'assets/uploads/products/' . $filename,
            'price_usd' => $request->price_usd,
            'price_after' => $request->price_after,
            'discount_from' => $request->discount_from,
            'discount_to' => $request->discount_to,
            'sort_order' => (Product::max('sort_order') ?? 0) + 1,
        ]);

        return redirect()->route('store.products.index')->with('success', 'Product added successfully');
    }

    public function edit(Request $request, Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $returnTo = $request->query('return_to');

        return view('store.products.edit', compact('product', 'categories', 'returnTo'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'image' => 'nullable|image|max:2048',
            'price_usd' => 'required|numeric|min:0',
            'price_after' => 'nullable|numeric|min:0|lt:price_usd',
            'discount_from' => 'nullable|date|required_with:discount_to',
            'discount_to' => 'nullable|date|after_or_equal:discount_from|required_with:discount_from',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price_usd' => $request->price_usd,
            'price_after' => $request->price_after,
            'discount_from' => $request->discount_from,
            'discount_to' => $request->discount_to,
        ];

        if ($request->hasFile('image')) {
            $filename = uploadImage('assets/uploads/products', $request->file('image'));
            $data['image'] = 'assets/uploads/products/' . $filename;
        }

        $product->update($data);

        $returnTo = $request->input('return_to');
        $redirectTo = ($returnTo && Str::startsWith($returnTo, url('/')))
            ? $returnTo
            : route('store.products.index');

        return redirect($redirectTo)->with('success', 'Product updated successfully');
    }

    public function toggle(Product $product)
    {
        $product->update(['active' => ! $product->active]);

        return back()->with('success', $product->active ? 'Product activated' : 'Product deactivated');
    }

    public function reorder(Request $request, Product $product)
    {
        $request->validate([
            'sort_order' => 'required|integer|min:1',
        ]);

        $newOrder = (int) $request->sort_order;

        DB::transaction(function () use ($product, $newOrder) {
            $existing = Product::where('sort_order', $newOrder)
                ->where('id', '!=', $product->id)
                ->first();

            if ($existing) {
                $existing->update(['sort_order' => $product->sort_order]);
            }

            $product->update(['sort_order' => $newOrder]);
        });

        return back()->with('success', 'Product order updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted');
    }
}

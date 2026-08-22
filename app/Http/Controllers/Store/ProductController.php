<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.products.index', compact('products'));
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
        ]);

        return redirect()->route('store.products.index')->with('success', 'Product added successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('store.products.edit', compact('product', 'categories'));
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

        return redirect()->route('store.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted');
    }
}

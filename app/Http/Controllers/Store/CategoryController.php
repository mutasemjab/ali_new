<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('store.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
        ]);

        Category::create([
            'name' => $request->name,
            'active' => $request->boolean('active', true),
        ]);

        return redirect()->route('store.categories.index')->with('success', 'Category added successfully');
    }

    public function edit(Category $category)
    {
        return view('store.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:200',
        ]);

        $category->update([
            'name' => $request->name,
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('store.categories.index')->with('success', 'Category updated successfully');
    }

    public function toggle(Category $category)
    {
        $category->update(['active' => ! $category->active]);

        return back()->with('success', $category->active ? 'Category activated' : 'Category deactivated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted');
    }
}

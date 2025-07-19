<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('superadmin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('superadmin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        Category::create($validated);
        return redirect()->route('superadmin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('superadmin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('superadmin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);
        $category->update($validated);
        return redirect()->route('superadmin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('superadmin.categories.index')->with('success', 'Category deleted successfully.');
    }
} 
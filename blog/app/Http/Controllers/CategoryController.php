<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories',
            'description' => 'nullable',
        ]);
        
        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'] ?? null;
        $category->save();
        
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->where('status', 'published')->orderBy('created_at', 'desc')->get();
        
        return view('categories.show', compact('category', 'posts'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
        ]);
        
        $category->name = $validated['name'];
        if ($category->name !== $validated['name']) {
            $category->slug = Str::slug($validated['name']);
        }
        $category->description = $validated['description'] ?? null;
        $category->save();
        
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->posts()->detach();
        $category->delete();
        
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
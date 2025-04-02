<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
                    ->with('categories')
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('posts.index', compact('posts'));
    }
    
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'status' => 'required|in:draft,published',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
        
        $post = new Post();
        $post->title = $validated['title'];
        $post->slug = Str::slug($validated['title']);
        $post->content = $validated['content'];
        $post->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150);
        $post->status = $validated['status'];
        $post->user_id = auth()->id();
        
        if ($validated['status'] === 'published') {
            $post->published_at = now();
        }
        
        $post->save();
        
        // Attach categories
        if (!empty($validated['categories'])) {
            $post->categories()->attach($validated['categories']);
        }
        
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
                  ->with(['user', 'categories'])
                  ->firstOrFail();
        
        return view('posts.show', compact('post'));
    }
    
    public function edit(Post $post)
    {
        // Check if user can update this post
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $categories = Category::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories'));
    }
    
    public function update(Request $request, Post $post)
    {
        // Check if user can update this post
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'status' => 'required|in:draft,published',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
        
        $post->title = $validated['title'];
        
        // Update slug only if title changed
        if ($post->title !== $validated['title']) {
            $post->slug = Str::slug($validated['title']);
        }
        
        $post->content = $validated['content'];
        $post->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150);
        $post->status = $validated['status'];
        
        // Set published_at if status changed to published
        if ($validated['status'] === 'published' && $post->status !== 'published') {
            $post->published_at = now();
        }
        
        $post->save();
        
        // Sync categories
        $post->categories()->sync($validated['categories'] ?? []);
        
        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }
    
    public function destroy(Post $post)
    {
        // Check if user can delete this post
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $post->categories()->detach();
        $post->delete();
        
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
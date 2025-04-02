<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'categories'])
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        $categories = Category::withCount('posts')->orderBy('name')->get();
                    
        return view('home', compact('posts', 'categories'));
    }
}
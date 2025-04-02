@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Posts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 flex items-center">
            <div class="bg-blue-100 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Posts</p>
                <p class="text-2xl font-bold">{{ Auth::user()->posts()->count() }}</p>
            </div>
        </div>
    </div>
    
    <!-- Published Posts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 flex items-center">
            <div class="bg-green-100 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Published Posts</p>
                <p class="text-2xl font-bold">{{ Auth::user()->posts()->where('status', 'published')->count() }}</p>
            </div>
        </div>
    </div>
    
    <!-- Draft Posts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 flex items-center">
            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Draft Posts</p>
                <p class="text-2xl font-bold">{{ Auth::user()->posts()->where('status', 'draft')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden col-span-1">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Quick Actions</h2>
        </div>
        <div class="p-6 space-y-4">
            <a href="{{ route('posts.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm text-center transition-colors">
                Create New Post
            </a>
            <a href="{{ route('posts.index') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md shadow-sm text-center transition-colors">
                Manage Posts
            </a>
            <a href="{{ route('categories.index') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md shadow-sm text-center transition-colors">
                Manage Categories
            </a>
            <a href="{{ route('profile.edit') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md shadow-sm text-center transition-colors">
                Edit Profile
            </a>
        </div>
    </div>
    
    <!-- Recent Posts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden col-span-1 md:col-span-2">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Recent Posts</h2>
            <a href="{{ route('posts.index') }}" class="text-sm text-white hover:text-blue-200 transition-colors">
                View All
            </a>
        </div>
        <div class="divide-y divide-gray-200">
            @php
                $recentPosts = Auth::user()->posts()->with('categories')->latest()->take(5)->get();
            @endphp
            
            @if($recentPosts->count() > 0)
                @foreach($recentPosts as $post)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $post->created_at->format('F j, Y') }}
                                </p>
                            </div>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                        
                        @if($post->categories->count() > 0)
                            <div class="mt-2 flex flex-wrap">
                                @foreach($post->categories as $category)
                                    <span class="px-2 py-1 mr-1 mb-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">You haven't created any posts yet.</p>
                    <a href="{{ route('posts.create') }}" class="mt-2 inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                        Create your first post
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
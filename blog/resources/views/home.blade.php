@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="md:col-span-2">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Latest Blog Posts</h1>
        
        @if($posts->count() > 0)
            <div class="space-y-8">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            
                            <div class="flex flex-wrap items-center text-gray-600 text-sm mb-4">
                                <div class="flex items-center mr-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $post->user->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $post->created_at->format('F j, Y') }}</span>
                                </div>
                            </div>
                            
                            @if($post->categories->count() > 0)
                                <div class="flex flex-wrap mb-4">
                                    @foreach($post->categories as $category)
                                        <a href="{{ route('categories.show', $category->slug) }}" class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2 mb-2 hover:bg-blue-200 transition-colors">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="text-gray-700 mb-4">
                                @if($post->excerpt)
                                    {{ $post->excerpt }}
                                @else
                                    {{ \Str::limit(strip_tags($post->content), 200) }}
                                @endif
                            </div>
                            
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                                Read more
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-600">No posts available yet.</p>
            </div>
        @endif
        
        @auth
            <div class="mt-8">
                <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Post
                </a>
            </div>
        @endauth
    </div>
    
    <!-- Sidebar -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Categories</h2>
            </div>
            <div class="p-6">
                @if($categories->count() > 0)
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="flex justify-between items-center text-gray-700 hover:text-blue-600 transition-colors py-2 border-b border-gray-100 group">
                                <span>{{ $category->name }}</span>
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No categories available.</p>
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">About This Blog</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">This is a simple blog built with Laravel. Feel free to browse through the posts or create your own account to start writing!</p>
                
                @guest
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Register
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
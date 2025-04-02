@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Back to Home
    </a>
</div>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
    @if($category->description)
        <div class="text-gray-600">{{ $category->description }}</div>
    @endif
</div>

<h2 class="text-2xl font-bold text-gray-900 mb-6">Posts in this category</h2>

@if($posts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600 transition-colors">
                            {{ $post->title }}
                        </a>
                    </h3>
                    
                    <div class="flex items-center text-gray-600 text-sm mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $post->created_at->format('F j, Y') }}</span>
                    </div>
                    
                    <div class="text-gray-700 mb-4">
                        @if($post->excerpt)
                            {{ $post->excerpt }}
                        @else
                            {{ \Str::limit(strip_tags($post->content), 150) }}
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
        <p class="text-gray-600">No posts in this category yet.</p>
    </div>
@endif

@auth
    <div class="mt-8">
        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Create New Post
        </a>
    </div>
@endauth
@endsection
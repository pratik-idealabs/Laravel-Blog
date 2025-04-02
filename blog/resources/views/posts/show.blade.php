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

<article class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
        
        <div class="flex flex-wrap items-center text-gray-600 text-sm mb-6">
            <div class="flex items-center mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>{{ $post->user->name }}</span>
            </div>
            <div class="flex items-center mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $post->created_at->format('F j, Y') }}</span>
            </div>
            @if($post->categories->count() > 0)
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <div class="flex flex-wrap">
                    @foreach($post->categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-blue-600 mr-2">
                            {{ $category->name }}{{ !$loop->last ? ',' : '' }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        @if($post->excerpt)
            <div class="bg-gray-50 border-l-4 border-blue-500 p-4 mb-6 italic">
                {{ $post->excerpt }}
            </div>
        @endif
        
        <div class="prose prose-blue max-w-none mb-6">
            {!! nl2br(e($post->content)) !!}
        </div>
        
        @auth
            @if($post->user_id === auth()->id())
                <div class="flex justify-end border-t pt-6 mt-6">
                    <a href="{{ route('posts.edit', $post) }}" class="flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Post
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center justify-center bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors" 
                            onclick="return confirm('Are you sure you want to delete this post?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Post
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</article>
@endsection
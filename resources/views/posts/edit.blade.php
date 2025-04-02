@extends('layouts.app')

@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('posts.index') }}" class="mr-4 text-blue-600 hover:text-blue-800 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Back to Posts
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Edit Post</h1>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea name="content" id="content" rows="12" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt (Optional)</label>
                <textarea name="excerpt" id="excerpt" rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A short summary of your post. If left empty, it will be generated from the content.</p>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                        <div class="flex items-center">
                            <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('categories')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="mt-2">
                    <a href="{{ route('categories.create') }}" class="text-sm text-blue-600 hover:underline flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Category
                    </a>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="mt-2 space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="draft" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('status', $post->status) === 'draft' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Save as Draft</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="published" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('status', $post->status) === 'published' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Publish Now</span>
                    </label>
                </div>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
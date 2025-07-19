@extends('layouts.frontend')

@section('title', $blog->meta_title ?? $blog->title)
@section('meta')
    @if($blog->meta_description)
        <meta name="description" content="{{ $blog->meta_description }}">
    @endif
    @if($blog->meta_keywords)
        <meta name="keywords" content="{{ $blog->meta_keywords }}">
    @endif
@endsection

@section('content')
<div class="container mx-auto px-4 py-10 max-w-2xl">
    <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-indigo-600 text-sm mb-6 inline-block">&larr; Back to Blog</a>
    <div class="bg-white rounded-lg shadow p-6">
        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" alt="Featured Image" class="w-full h-64 object-cover rounded mb-6">
        @endif
        <h1 class="text-3xl font-bold mb-2">{{ $blog->title }}</h1>
        <div class="flex items-center text-sm text-gray-500 mb-4 space-x-2">
            <span>{{ $blog->created_at->format('Y-m-d') }}</span>
            @if($blog->category)
                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-medium">{{ $blog->category->name }}</span>
            @endif
        </div>
        <div class="prose max-w-none text-gray-800">
            {!! $blog->content !!}
        </div>
    </div>
</div>
@endsection 
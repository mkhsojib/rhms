@extends('layouts.frontend')

@section('content')
<div class="container mx-auto py-8 px-4 mt-16">
    <h1 class="text-3xl font-bold mb-8">Blog</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @forelse($blogs as $blog)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Image" class="w-full h-48 object-cover">
                @endif
                <div class="p-5 flex flex-col flex-1">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('blog.show', $blog) }}" class="hover:text-indigo-600 transition">{{ $blog->title }}</a>
                    </h2>
                    <div class="flex items-center text-sm text-gray-500 mb-2 space-x-2">
                        <span>{{ $blog->created_at->format('Y-m-d') }}</span>
                        @if($blog->category)
                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-medium">{{ $blog->category->name }}</span>
                        @endif
                    </div>
                    <p class="text-gray-700 mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}</p>
                    <div class="mt-auto">
                        <a href="{{ route('blog.show', $blog) }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition text-sm font-medium">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 md:col-span-3">
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-center">No blogs found.</div>
            </div>
        @endforelse
    </div>
    <div class="flex justify-center mt-8">
        {{ $blogs->links() }}
    </div>
</div>
@endsection 
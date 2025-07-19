@extends('layouts.app')

@section('title', 'Blog Details')

@section('content_header')
    <h1>Blog Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">{{ $blog->title }}</h3>
        </div>
        <div class="card-body">
            @if($blog->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Featured Image" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                </div>
            @endif
            <div class="mb-2">
                <span class="badge badge-{{ $blog->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($blog->status) }}</span>
                @if($blog->category)
                    <span class="badge badge-info">{{ $blog->category->name }}</span>
                @endif
            </div>
            <div class="mb-3">
                <small>Created: {{ $blog->created_at->format('Y-m-d H:i') }}</small><br>
                <small>Updated: {{ $blog->updated_at->format('Y-m-d H:i') }}</small>
            </div>
            <div class="mb-4">
                {!! $blog->content !!}
            </div>
            <a href="{{ route('superadmin.blogs.edit', $blog) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('superadmin.blogs.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection 
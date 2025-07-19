@extends('layouts.app')

@section('title', 'Create Blog')

@section('content_header')
    <h1>Create Blog</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">New Blog</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Featured Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
                    @error('meta_title')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <input type="text" name="meta_description" id="meta_description" class="form-control" value="{{ old('meta_description') }}">
                    @error('meta_description')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                    @error('meta_keywords')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control summernote" rows="6" required>{{ old('content') }}</textarea>
                    @error('content')
                        <span class="badge badge-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('superadmin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 250
            });
        });
    </script>
@endsection 
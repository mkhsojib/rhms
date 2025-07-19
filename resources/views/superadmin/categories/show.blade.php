@extends('layouts.app')

@section('title', 'Category Details')

@section('content_header')
    <h1>Category Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">{{ $category->name }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Name:</strong> {{ $category->name }}
            </div>
            <div class="mb-3">
                <small>Created: {{ $category->created_at->format('Y-m-d H:i') }}</small><br>
                <small>Updated: {{ $category->updated_at->format('Y-m-d H:i') }}</small>
            </div>
            <a href="{{ route('superadmin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('superadmin.categories.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection 
@extends('layouts.app')

@section('title', 'Questions Management')

@section('content_header')
    <h1>Questions Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Questions</h3>
            <div class="card-tools">
                <a href="{{ route('superadmin.questions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Question
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#searchFilters" aria-expanded="false" aria-controls="searchFilters">
                    <i class="fas fa-search"></i> Search & Filters
                </button>
            </div>
            
            <div class="collapse {{ (request('search') || request('category') || request('input_type') || request('status') !== null || request('required') !== null) ? 'show' : '' }}" id="searchFilters">
                <form method="GET" action="{{ route('superadmin.questions.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search questions..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    <option value="ruqyah" {{ request('category') == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                    <option value="hijama" {{ request('category') == 'hijama' ? 'selected' : '' }}>Hijama</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="input_type" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="text" {{ request('input_type') == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="radio" {{ request('input_type') == 'radio' ? 'selected' : '' }}>Radio</option>
                                    <option value="checkbox" {{ request('input_type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="required" class="form-control">
                                    <option value="">All Required</option>
                                    <option value="1" {{ request('required') === '1' ? 'selected' : '' }}>Required</option>
                                    <option value="0" {{ request('required') === '0' ? 'selected' : '' }}>Optional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('superadmin.questions.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset Filters
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Required</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->question_text }}</td>
                                <td>
                                    <span class="badge badge-{{ $question->input_type === 'text' ? 'info' : ($question->input_type === 'radio' ? 'success' : 'warning') }}">
                                        {{ ucfirst($question->input_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $question->category === 'ruqyah' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($question->category) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $question->is_active ? 'success' : 'danger' }}">
                                        {{ $question->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $question->is_required ? 'warning' : 'secondary' }}">
                                        {{ $question->is_required ? 'Required' : 'Optional' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('superadmin.questions.edit', $question) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('superadmin.questions.destroy', $question) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No questions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($questions->hasPages())
                <div class="mt-3">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
@stop 
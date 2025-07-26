@extends('adminlte::page')

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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Status</th>
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
                            <td colspan="6" class="text-center">No questions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop 
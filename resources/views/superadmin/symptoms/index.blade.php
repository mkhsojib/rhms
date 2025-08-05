@extends('layouts.app')

@section('title', 'Symptoms Management')

@section('content_header')
    <h1>Symptoms Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Symptoms</h3>
            <div class="card-tools">
                <a href="{{ route('superadmin.symptoms.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Symptom
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($symptoms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($symptoms as $symptom)
                                <tr>
                                    <td>{{ $symptom->id }}</td>
                                    <td>
                                        <strong>{{ $symptom->name }}</strong>
                                        @if($symptom->description)
                                            <br><small class="text-muted">{{ Str::limit($symptom->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($symptom->category)
                                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $symptom->category)) }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($symptom->type)
                                            <span class="badge badge-warning">{{ ucfirst($symptom->type) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($symptom->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $symptom->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('superadmin.symptoms.show', $symptom) }}" 
                                               class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('superadmin.symptoms.edit', $symptom) }}" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('superadmin.symptoms.destroy', $symptom) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this symptom?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $symptoms->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-stethoscope fa-3x text-muted mb-3"></i>
                    <h4>No Symptoms Found</h4>
                    <p class="text-muted">Start by adding your first symptom to the system.</p>
                    <a href="{{ route('superadmin.symptoms.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Symptom
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop
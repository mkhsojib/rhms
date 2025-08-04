@extends('layouts.app')

@section('title', 'Medicines Management')

@section('content_header')
    <h1>Medicines Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Medicines</h3>
            <div class="card-tools">
                <a href="{{ route('superadmin.medicines.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Medicine
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($medicines->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Dosage</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicines as $medicine)
                                <tr>
                                    <td>{{ $medicine->id }}</td>
                                    <td>
                                        <strong>{{ $medicine->name }}</strong>
                                        @if($medicine->description)
                                            <br><small class="text-muted">{{ Str::limit($medicine->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($medicine->type) }}</span>
                                    </td>
                                    <td>{{ $medicine->dosage ?? 'N/A' }}</td>
                                    <td>
                                        @if($medicine->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $medicine->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('superadmin.medicines.show', $medicine) }}" 
                                               class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('superadmin.medicines.edit', $medicine) }}" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('superadmin.medicines.destroy', $medicine) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this medicine?')">
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
                    {{ $medicines->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                    <h4>No Medicines Found</h4>
                    <p class="text-muted">Start by adding your first medicine to the system.</p>
                    <a href="{{ route('superadmin.medicines.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Medicine
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop
@extends('layouts.app')

@section('title', 'Treatment Records')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Treatment Records</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-right">
                <a href="{{ route('admin.treatments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Treatment
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Treatment Records</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @endif

            @if($treatments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Treatment Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($treatments as $treatment)
                                <tr>
                                    <td>{{ $treatment->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.appointments.show', $treatment->appointment_id) }}">
                                            {{ $treatment->appointment->patient->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($treatment->treatment_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $treatment->treatment_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($treatment->status === 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($treatment->status === 'in_progress')
                                            <span class="badge badge-warning">In Progress</span>
                                        @else
                                            <span class="badge badge-secondary">Scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($treatment->notes)
                                            {{ Str::limit($treatment->notes, 50) }}
                                        @else
                                            <span class="text-muted">No notes</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.treatments.show', $treatment) }}" 
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.treatments.edit', $treatment) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.treatments.destroy', $treatment) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this treatment?')" 
                                                        title="Delete">
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

                <div class="mt-3">
                    {{ $treatments->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-hand-holding-medical fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Treatment Records Found</h4>
                    <p class="text-muted">You haven't created any treatment records yet.</p>
                    <a href="{{ route('admin.treatments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Your First Treatment
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            background-color: #f4f6f9;
        }
        .btn-group .btn {
            margin-right: 2px;
        }
        .btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop 
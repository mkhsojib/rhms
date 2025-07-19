@extends('layouts.app')

@section('title', 'Treatment Details')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Treatment Details</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-right">
                <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Treatment
                </a>
                <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Treatments
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hand-holding-medical"></i> Treatment Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Treatment ID:</strong></td>
                                    <td>#{{ $treatment->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Treatment Type:</strong></td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($treatment->treatment_type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Treatment Date:</strong></td>
                                    <td>{{ $treatment->treatment_date->format('l, F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($treatment->status === 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($treatment->status === 'in_progress')
                                            <span class="badge badge-warning">In Progress</span>
                                        @else
                                            <span class="badge badge-secondary">Scheduled</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Duration:</strong></td>
                                    <td>
                                        @if($treatment->duration)
                                            {{ $treatment->duration }} minutes
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Cost:</strong></td>
                                    <td>
                                        @if($treatment->cost)
                                            ${{ number_format($treatment->cost, 2) }}
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $treatment->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $treatment->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                @if($treatment->createdBy)
                                <tr>
                                    <td><strong>Created By:</strong></td>
                                    <td>{{ $treatment->createdBy->name }} ({{ $treatment->createdBy->role }})</td>
                                </tr>
                                @endif
                                @if($treatment->updatedBy)
                                <tr>
                                    <td><strong>Last Updated By:</strong></td>
                                    <td>{{ $treatment->updatedBy->name }} ({{ $treatment->updatedBy->role }})</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($treatment->notes)
                        <div class="mt-4">
                            <h5><i class="fas fa-sticky-note"></i> Treatment Notes</h5>
                            <div class="alert alert-info">
                                {{ $treatment->notes }}
                            </div>
                        </div>
                    @endif

                    @if($treatment->creation_notes)
                        <div class="mt-4">
                            <h5><i class="fas fa-plus-circle"></i> Creation Notes</h5>
                            <div class="alert alert-success">
                                {{ $treatment->creation_notes }}
                            </div>
                        </div>
                    @endif

                    @if($treatment->update_notes)
                        <div class="mt-4">
                            <h5><i class="fas fa-edit"></i> Update Notes</h5>
                            <div class="alert alert-warning">
                                {{ $treatment->update_notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Patient Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-3x text-primary"></i>
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $treatment->appointment->patient->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $treatment->appointment->patient->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>
                                @if($treatment->appointment->patient->phone)
                                    {{ $treatment->appointment->patient->phone }}
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <a href="{{ route('admin.appointments.show', $treatment->appointment_id) }}" 
                       class="btn btn-info btn-block">
                        <i class="fas fa-calendar"></i> View Appointment
                    </a>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check"></i> Related Appointment
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td>{{ $treatment->appointment->appointment_date->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Time:</strong></td>
                            <td>{{ $treatment->appointment->appointment_date->format('h:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($treatment->appointment->status === 'confirmed')
                                    <span class="badge badge-success">Confirmed</span>
                                @elseif($treatment->appointment->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($treatment->appointment->status === 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($treatment->appointment->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i> Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.treatments.edit', $treatment) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Treatment
                        </a>
                        <form action="{{ route('admin.treatments.destroy', $treatment) }}" 
                              method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this treatment?')">
                                <i class="fas fa-trash"></i> Delete Treatment
                            </button>
                        </form>
                        <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table-borderless td {
            border: none;
            padding: 0.5rem 0;
        }
        .table-borderless td:first-child {
            font-weight: 600;
            width: 40%;
        }
        .card-header h3 {
            margin-bottom: 0;
        }
        .btn-group .btn {
            margin-right: 5px;
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
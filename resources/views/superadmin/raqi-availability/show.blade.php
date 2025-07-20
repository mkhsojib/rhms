@extends('layouts.app')

@section('title', 'View Raqi Availability')

@section('content_header')
    <h1>View Raqi Availability</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Availability Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.raqi-availability.edit', $availability) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('superadmin.raqi-availability.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Raqi Name:</th>
                                    <td>{{ $availability->practitioner->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $availability->practitioner->email }}</td>
                                </tr>
                                <tr>
                                    <th>Specialization:</th>
                                    <td>
                                        @if($availability->practitioner->specialization)
                                            <span class="badge badge-info">{{ $availability->practitioner->specialization_label }}</span>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>
                                        <strong>{{ $availability->availability_date->format('M d, Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $availability->availability_date->format('l') }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Start Time:</th>
                                    <td><strong>{{ $availability->start_time }}</strong></td>
                                </tr>
                                <tr>
                                    <th>End Time:</th>
                                    <td><strong>{{ $availability->end_time }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Slot Duration:</th>
                                    <td><strong>{{ $availability->slot_duration }} minutes</strong></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($availability->is_available)
                                            <span class="badge badge-success">Available</span>
                                        @else
                                            <span class="badge badge-danger">Not Available</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($availability->notes)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Notes:</h5>
                                <div class="alert alert-info">
                                    {{ $availability->notes }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Time Slots Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Generated Time Slots</h3>
                </div>
                <div class="card-body">
                    @php
                        $timeSlots = $availability->generateTimeSlots();
                    @endphp
                    
                    @if(count($timeSlots) > 0)
                        <div class="row">
                            @foreach($timeSlots as $slot)
                                <div class="col-md-3 mb-2">
                                    <span class="badge badge-primary p-2">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">Total: {{ count($timeSlots) }} time slots</small>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> No time slots can be generated with the current settings.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Appointments Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Appointments on This Date</h3>
                </div>
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <div class="list-group">
                            @foreach($appointments as $appointment)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $appointment->user->name }}</h6>
                                        <small class="text-muted">{{ $appointment->appointment_time }}</small>
                                    </div>
                                    <p class="mb-1">
                                        <span class="badge badge-{{ $appointment->type == 'ruqyah' ? 'success' : 'info' }}">
                                            {{ ucfirst($appointment->type) }}
                                        </span>
                                        <span class="badge badge-{{ $appointment->status == 'confirmed' ? 'success' : ($appointment->status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </p>
                                    <small class="text-muted">{{ $appointment->user->email }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>No appointments scheduled for this date.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('superadmin.raqi-availability.edit', $availability) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Availability
                        </a>
                        <form action="{{ route('superadmin.raqi-availability.destroy', $availability) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this availability?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Availability
                            </button>
                        </form>
                        <a href="{{ route('superadmin.raqi-availability.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Availability
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .table-borderless th {
        border: none;
        font-weight: 600;
        color: #495057;
    }
    .table-borderless td {
        border: none;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@stop 
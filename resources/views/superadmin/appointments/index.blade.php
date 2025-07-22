@extends('layouts.app')

@section('title', 'All Appointments')

@section('content_header')
    <h1>All Appointments</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $appointments->where('status', 'pending')->count() }}</h3>
                    <p>Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $appointments->where('status', 'approved')->count() }}</h3>
                    <p>Approved</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $appointments->where('status', 'completed')->count() }}</h3>
                    <p>Completed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $appointments->where('status', 'rejected')->count() }}</h3>
                    <p>Rejected</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">All Appointments</h3>
            <a href="{{ route('superadmin.appointments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Appointment
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Appointment No</th>
                            <th>Patient</th>
                            <th>Practitioner</th>
                            <th>Type</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td><span class="badge badge-primary">{{ $appointment->appointment_no }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="avatar-title bg-info rounded-circle">
                                                {{ strtoupper(substr($appointment->patient->name ?? 'N/A', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $appointment->patient->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $appointment->patient->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="avatar-title bg-warning rounded-circle">
                                                {{ strtoupper(substr($appointment->practitioner->name ?? 'N/A', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $appointment->practitioner->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $appointment->practitioner->specialization_label ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @switch($appointment->type)
                                        @case('ruqyah')
                                            <span class="badge badge-info">Ruqyah</span>
                                            @break
                                        @case('hijama')
                                            <span class="badge badge-warning">Hijama</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ ucfirst($appointment->type) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="font-weight-bold">{{ $appointment->formatDate('M d, Y') }}</div>
                                        <small class="text-muted">{{ $appointment->appointment_time }}</small>
                                    </div>
                                </td>
                                <td>
                                    @switch($appointment->status)
                                        @case('pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @break
                                        @case('approved')
                                            <span class="badge badge-success">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-info">Completed</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ ucfirst($appointment->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($appointment->invoice)
                                        @if($appointment->invoice->status === 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-warning">Unpaid</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('superadmin.appointments.show', $appointment) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.appointments.edit', $appointment) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if($appointment->status === 'pending')
                                            <form action="{{ route('superadmin.appointments.approve', $appointment) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        title="Approve" onclick="return confirm('Approve this appointment?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('superadmin.appointments.reject', $appointment) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Reject" onclick="return confirm('Reject this appointment?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($appointment->status === 'approved')
                                            <form action="{{ route('superadmin.appointments.complete', $appointment) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        title="Mark Complete" onclick="return confirm('Mark this appointment as completed?')">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('superadmin.appointments.destroy', $appointment) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No appointments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($appointments->hasPages())
                <div class="mt-3">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
</style>
@stop 
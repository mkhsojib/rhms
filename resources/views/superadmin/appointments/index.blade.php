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
        
        <!-- Search Form -->
        <div class="card-body border-bottom">
            <form action="{{ route('superadmin.appointments.index') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="appointment_no">Appointment No</label>
                            <input type="text" name="appointment_no" id="appointment_no" class="form-control form-control-sm" value="{{ request('appointment_no') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="patient_name">Patient</label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control form-control-sm" value="{{ request('patient_name') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="payment_status">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="no_invoice" {{ request('payment_status') == 'no_invoice' ? 'selected' : '' }}>No Invoice</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="ruqyah" {{ request('type') == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                <option value="hijama" {{ request('type') == 'hijama' ? 'selected' : '' }}>Hijama</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" name="date_from" id="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" name="date_to" id="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-sm mr-2">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="{{ route('superadmin.appointments.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
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
                                    @php
                                        $sessionTypeName = $appointment->session_type_name ?? $appointment->sessionType->type ?? $appointment->sessionType->name ?? null;
                                    @endphp
                                    @if($sessionTypeName)
                                        <br>
                                        <small class="text-muted">
                                            <strong>Session:</strong> {{ ucwords(str_replace('_', ' ', $sessionTypeName)) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="font-weight-bold">{{ $appointment->formatDate('M d, Y') }}</div>
                                        <small class="text-muted">
                                            @if($appointment->appointment_time)
                                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                            @endif
                                            @if($appointment->appointment_end_time)
                                                - {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('g:i A') }}
                                            @endif
                                        </small>
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
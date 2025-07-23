@extends('layouts.app')

@section('title', 'Appointments Management')

@section('page-title', 'Appointments')

@section('breadcrumb')
    <li class="breadcrumb-item active">Appointments</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage Appointments</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> New Appointment
                    </a>
                </div>
            </div>
            
            <!-- Search Form -->
            <div class="card-body border-bottom">
                <form action="{{ route('admin.appointments.index') }}" method="GET" class="mb-0">
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
                                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">
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
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $appointment->type === 'ruqyah' ? 'info' : 'warning' }}">
                                            {{ ucfirst($appointment->type) }}
                                        </span>
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
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">
                                            @if($appointment->appointment_time)
                                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                            @endif
                                            @if($appointment->appointment_end_time)
                                                - {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('g:i A') }}
                                            @endif
                                        </small>
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
                                            <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($appointment->status === 'pending')
                                                <form action="{{ route('admin.appointments.approve', $appointment) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            onclick="return confirm('Approve this appointment?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.appointments.reject', $appointment) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Reject this appointment?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($appointment->status === 'approved')
                                                <form action="{{ route('admin.appointments.complete', $appointment) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-info" 
                                                            onclick="return confirm('Mark as completed?')">
                                                        <i class="fas fa-check-double"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Delete this appointment?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
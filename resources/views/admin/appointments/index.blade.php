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
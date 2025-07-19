@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_appointments'] }}</h3>
                <p>Total Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="small-box-footer">
                View All <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending_appointments'] }}</h3>
                <p>Pending Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="small-box-footer">
                View All <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['approved_appointments'] }}</h3>
                <p>Approved Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="small-box-footer">
                View All <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['total_treatments'] }}</h3>
                <p>Total Treatments</p>
            </div>
            <div class="icon">
                <i class="fas fa-stethoscope"></i>
            </div>
            <a href="{{ route('admin.treatments.index') }}" class="small-box-footer">
                View All <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Today's Appointments</h3>
            </div>
            <div class="card-body">
                @if($today_appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Patient</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($today_appointments as $appointment)
                                    <tr>
                                        <td>
                                            {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}
                                        </td>
                                        <td>{{ $appointment->patient->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $appointment->type === 'ruqyah' ? 'info' : 'warning' }}">
                                                {{ ucfirst($appointment->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @switch($appointment->status)
                                                @case('pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                    @break
                                                @case('approved')
                                                    <span class="badge badge-success">Approved</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge badge-info">Completed</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">{{ ucfirst($appointment->status) }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No appointments scheduled for today.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upcoming Appointments</h3>
            </div>
            <div class="card-body">
                @if($upcoming_appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Patient</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcoming_appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->formatDate('M d, Y') }}</td>
                                        <td>
                                            {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}
                                        </td>
                                        <td>{{ $appointment->patient->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $appointment->type === 'ruqyah' ? 'info' : 'warning' }}">
                                                {{ ucfirst($appointment->type) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No upcoming appointments.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary mr-2">
                    <i class="fas fa-plus"></i> Create New Appointment
                </a>
                <a href="{{ route('admin.treatments.create') }}" class="btn btn-success mr-2">
                    <i class="fas fa-stethoscope"></i> Add Treatment
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-info">
                    <i class="fas fa-calendar-check"></i> Manage Appointments
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
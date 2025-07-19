@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('page-title', 'Edit Appointment')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.show', $appointment) }}">Details</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Appointment #{{ $appointment->id }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Details
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">Patient</label>
                                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('user_id', $appointment->user_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Treatment Type</label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">Select Type</option>
                                    <option value="ruqyah" {{ old('type', $appointment->type) == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                    <option value="hijama" {{ old('type', $appointment->type) == 'hijama' ? 'selected' : '' }}>Hijama</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_date">Appointment Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" 
                                       class="form-control @error('appointment_date') is-invalid @enderror"
                                       value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required>
                                @error('appointment_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_time">Appointment Time</label>
                                <select name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" required>
                                    <option value="">Select Time</option>
                                    <option value="09:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                                    <option value="10:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                                    <option value="11:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                                    <option value="12:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                                    <option value="14:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                                    <option value="15:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                                    <option value="16:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                                    <option value="17:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '17:00' ? 'selected' : '' }}>5:00 PM</option>
                                    <option value="18:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '18:00' ? 'selected' : '' }}>6:00 PM</option>
                                    <option value="19:00" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == '19:00' ? 'selected' : '' }}>7:00 PM</option>
                                </select>
                                @error('appointment_time')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $appointment->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $appointment->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="symptoms">Patient Symptoms/Notes</label>
                        <textarea name="symptoms" id="symptoms" rows="3" 
                                  class="form-control @error('symptoms') is-invalid @enderror"
                                  placeholder="Patient's symptoms or notes...">{{ old('symptoms', $appointment->symptoms) }}</textarea>
                        @error('symptoms')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes">Practitioner Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Practitioner's notes...">{{ old('notes', $appointment->notes) }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Appointment
                        </button>
                        <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
                <p><strong>Type:</strong> {{ ucfirst($appointment->type) }}</p>
                <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }}</p>
                <p><strong>Time:</strong> {{ $appointment->appointment_time->format('g:i A') }}</p>
                <p><strong>Status:</strong> 
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
                </p>
                <p><strong>Created:</strong> {{ $appointment->created_at->format('M d, Y g:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $appointment->updated_at->format('M d, Y g:i A') }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block" 
                                    onclick="return confirm('Approve this appointment?')">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-block" 
                                    onclick="return confirm('Reject this appointment?')">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                    @endif

                    @if($appointment->status === 'approved')
                        <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info btn-block" 
                                    onclick="return confirm('Mark as completed?')">
                                <i class="fas fa-check-double"></i> Mark as Completed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('title', 'Create Treatment')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create New Treatment</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-right">
                <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Treatments
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Treatment Information</h3>
        </div>
        <form action="{{ route('admin.treatments.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($selectedAppointment)
                    <div class="alert alert-info">
                        <h5><i class="fas fa-user"></i> Patient Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Name:</strong> {{ $selectedAppointment->patient->name }}<br>
                                <strong>Email:</strong> {{ $selectedAppointment->patient->email }}<br>
                                <strong>Phone:</strong> {{ $selectedAppointment->patient->phone ?? 'Not provided' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Appointment Date:</strong> {{ $selectedAppointment->appointment_date->format('M d, Y') }}<br>
                                <strong>Appointment Time:</strong> {{ $selectedAppointment->appointment_time->format('h:i A') }}<br>
                                <strong>Type:</strong> <span class="badge badge-{{ $selectedAppointment->type === 'ruqyah' ? 'info' : 'warning' }}">{{ ucfirst($selectedAppointment->type) }}</span>
                            </div>
                        </div>
                        @if($selectedAppointment->symptoms)
                            <div class="mt-2">
                                <strong>Symptoms/Notes:</strong> {{ $selectedAppointment->symptoms }}
                            </div>
                        @endif
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_id">Appointment <span class="text-danger">*</span></label>
                            @if($selectedAppointment)
                                <!-- Pre-selected appointment - readonly -->
                                <input type="hidden" name="appointment_id" value="{{ $selectedAppointment->id }}">
                                <input type="text" class="form-control" value="{{ $selectedAppointment->patient->name }} - {{ $selectedAppointment->appointment_date->format('M d, Y h:i A') }}" readonly>
                                <small class="form-text text-muted">Patient: {{ $selectedAppointment->patient->name }} | Email: {{ $selectedAppointment->patient->email }}</small>
                            @else
                                <!-- Dropdown for appointment selection -->
                                <select name="appointment_id" id="appointment_id" class="form-control @error('appointment_id') is-invalid @enderror" required>
                                    <option value="">Select an appointment</option>
                                    @foreach($appointments as $appointment)
                                        <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                            {{ $appointment->patient->name }} - {{ $appointment->appointment_date->format('M d, Y h:i A') }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('appointment_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="treatment_type">Treatment Type <span class="text-danger">*</span></label>
                            <select name="treatment_type" id="treatment_type" class="form-control @error('treatment_type') is-invalid @enderror" required>
                                <option value="">Select treatment type</option>
                                <option value="ruqyah" {{ old('treatment_type') == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                <option value="hijama" {{ old('treatment_type') == 'hijama' ? 'selected' : '' }}>Hijama</option>
                                <option value="both" {{ old('treatment_type') == 'both' ? 'selected' : '' }}>Both (Ruqyah & Hijama)</option>
                            </select>
                            @error('treatment_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="treatment_date">Treatment Date <span class="text-danger">*</span></label>
                            <input type="date" name="treatment_date" id="treatment_date" 
                                   class="form-control @error('treatment_date') is-invalid @enderror" 
                                   value="{{ old('treatment_date', date('Y-m-d')) }}" required>
                            @error('treatment_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Treatment Notes</label>
                    <textarea name="notes" id="notes" rows="4" 
                              class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Enter treatment notes, observations, or recommendations...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" name="duration" id="duration" 
                           class="form-control @error('duration') is-invalid @enderror" 
                           value="{{ old('duration') }}" min="1" max="480" 
                           placeholder="Enter treatment duration in minutes">
                    @error('duration')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cost">Treatment Cost</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" name="cost" id="cost" 
                               class="form-control @error('cost') is-invalid @enderror" 
                               value="{{ old('cost') }}" min="0" step="0.01" 
                               placeholder="Enter treatment cost">
                    </div>
                    @error('cost')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Treatment
                </button>
                <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        .form-group label {
            font-weight: 600;
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            $('#treatment_date').attr('min', today);
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop 
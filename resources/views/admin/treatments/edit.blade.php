@extends('layouts.app')

@section('title', 'Edit Treatment')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Treatment</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-right">
                <a href="{{ route('admin.treatments.show', $treatment) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> View Treatment
                </a>
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
            <h3 class="card-title">Update Treatment Information</h3>
        </div>
        <form action="{{ route('admin.treatments.update', $treatment) }}" method="POST">
            @csrf
            @method('PUT')
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_id">Appointment <span class="text-danger">*</span></label>
                            <select name="appointment_id" id="appointment_id" class="form-control @error('appointment_id') is-invalid @enderror" required>
                                <option value="">Select an appointment</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}" 
                                            {{ old('appointment_id', $treatment->appointment_id) == $appointment->id ? 'selected' : '' }}>
                                        {{ $appointment->patient->name }} - {{ $appointment->appointment_date->format('M d, Y h:i A') }}
                                    </option>
                                @endforeach
                            </select>
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
                                <option value="ruqyah" {{ old('treatment_type', $treatment->treatment_type) == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                <option value="hijama" {{ old('treatment_type', $treatment->treatment_type) == 'hijama' ? 'selected' : '' }}>Hijama</option>
                                <option value="both" {{ old('treatment_type', $treatment->treatment_type) == 'both' ? 'selected' : '' }}>Both (Ruqyah & Hijama)</option>
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
                                   value="{{ old('treatment_date', $treatment->treatment_date->format('Y-m-d')) }}" required>
                            @error('treatment_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="scheduled" {{ old('status', $treatment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in_progress" {{ old('status', $treatment->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $treatment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
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
                              placeholder="Enter treatment notes, observations, or recommendations...">{{ old('notes', $treatment->notes) }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration">Duration (minutes)</label>
                            <input type="number" name="duration" id="duration" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   value="{{ old('duration', $treatment->duration) }}" min="1" max="480" 
                                   placeholder="Enter treatment duration in minutes">
                            @error('duration')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">Treatment Cost</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="cost" id="cost" 
                                       class="form-control @error('cost') is-invalid @enderror" 
                                       value="{{ old('cost', $treatment->cost) }}" min="0" step="0.01" 
                                       placeholder="Enter treatment cost">
                            </div>
                            @error('cost')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Treatment
                </button>
                <a href="{{ route('admin.treatments.show', $treatment) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> View Treatment
                </a>
                <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Treatment History -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history"></i> Treatment History
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $treatment->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Last Updated:</strong></td>
                            <td>{{ $treatment->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Created By:</strong></td>
                            <td>{{ $treatment->practitioner->name ?? 'System' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Patient:</strong></td>
                            <td>{{ $treatment->appointment->patient->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
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
        .table-borderless td {
            border: none;
            padding: 0.5rem 0;
        }
        .table-borderless td:first-child {
            font-weight: 600;
            width: 40%;
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
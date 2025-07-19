@extends('layouts.app')

@section('title', 'Edit Treatment')

@section('content_header')
    <h1>Edit Treatment</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.treatments.update', $treatment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_id">Appointment *</label>
                            <select name="appointment_id" id="appointment_id" class="form-control @error('appointment_id') is-invalid @enderror" required>
                                <option value="">Select Approved Appointment</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}" 
                                            {{ old('appointment_id', $treatment->appointment_id) == $appointment->id ? 'selected' : '' }}>
                                        #{{ $appointment->id }} - {{ $appointment->patient->name }} 
                                        ({{ ucfirst($appointment->type) }}) - 
                                        {{ $appointment->appointment_date->format('M d, Y') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('appointment_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Only approved appointments without existing treatments (or current treatment) are shown</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="treatment_date">Treatment Date *</label>
                            <input type="date" name="treatment_date" id="treatment_date" 
                                   class="form-control @error('treatment_date') is-invalid @enderror" 
                                   value="{{ old('treatment_date', $treatment->treatment_date->format('Y-m-d')) }}" required>
                            @error('treatment_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration">Duration (minutes) *</label>
                            <input type="number" name="duration" id="duration" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   value="{{ old('duration', $treatment->duration) }}" min="15" max="480" required>
                            @error('duration')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Duration between 15 and 480 minutes</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">Cost ($) *</label>
                            <input type="number" name="cost" id="cost" step="0.01" 
                                   class="form-control @error('cost') is-invalid @enderror" 
                                   value="{{ old('cost', $treatment->cost) }}" min="0" required>
                            @error('cost')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="outcome">Treatment Outcome *</label>
                            <select name="outcome" id="outcome" class="form-control @error('outcome') is-invalid @enderror" required>
                                <option value="">Select Outcome</option>
                                <option value="successful" {{ old('outcome', $treatment->outcome) == 'successful' ? 'selected' : '' }}>Successful</option>
                                <option value="partial" {{ old('outcome', $treatment->outcome) == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="unsuccessful" {{ old('outcome', $treatment->outcome) == 'unsuccessful' ? 'selected' : '' }}>Unsuccessful</option>
                            </select>
                            @error('outcome')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Treatment Notes</label>
                    <textarea name="notes" id="notes" rows="4" 
                              class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Describe the treatment procedure, observations, and recommendations">{{ old('notes', $treatment->notes) }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Treatment
                    </button>
                    <a href="{{ route('superadmin.treatments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop 
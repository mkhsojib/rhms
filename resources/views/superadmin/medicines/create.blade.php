@extends('layouts.app')

@section('title', 'Add New Medicine')

@section('content_header')
    <h1>Add New Medicine</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.medicines.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Medicine Name *</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Medicine Type *</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="capsule" {{ old('type') == 'capsule' ? 'selected' : '' }}>Capsule</option>
                                <option value="syrup" {{ old('type') == 'syrup' ? 'selected' : '' }}>Syrup</option>
                                <option value="injection" {{ old('type') == 'injection' ? 'selected' : '' }}>Injection</option>
                                <option value="cream" {{ old('type') == 'cream' ? 'selected' : '' }}>Cream/Ointment</option>
                                <option value="drops" {{ old('type') == 'drops' ? 'selected' : '' }}>Drops</option>
                                <option value="powder" {{ old('type') == 'powder' ? 'selected' : '' }}>Powder</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
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
                            <label for="dosage">Standard Dosage</label>
                            <input type="text" name="dosage" id="dosage" 
                                   class="form-control @error('dosage') is-invalid @enderror" 
                                   value="{{ old('dosage') }}" 
                                   placeholder="e.g., 500mg, 10ml, 1 tablet">
                            @error('dosage')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Standard dosage per administration</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" 
                                       class="form-check-input" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Available for prescription)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-control @error('description') is-invalid @enderror" 
                              placeholder="Brief description of the medicine, its uses, etc.">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instructions">General Instructions</label>
                    <textarea name="instructions" id="instructions" rows="4" 
                              class="form-control @error('instructions') is-invalid @enderror" 
                              placeholder="General instructions for taking this medicine (e.g., take with food, avoid alcohol, etc.)">{{ old('instructions') }}</textarea>
                    @error('instructions')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Medicine
                    </button>
                    <a href="{{ route('superadmin.medicines.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
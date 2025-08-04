@extends('layouts.app')

@section('title', 'Add New Symptom')

@section('content_header')
    <h1>Add New Symptom</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.symptoms.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Symptom Name *</label>
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
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="">Select Category</option>
                                <option value="physical" {{ old('category') == 'physical' ? 'selected' : '' }}>Physical</option>
                                <option value="mental" {{ old('category') == 'mental' ? 'selected' : '' }}>Mental/Emotional</option>
                                <option value="spiritual" {{ old('category') == 'spiritual' ? 'selected' : '' }}>Spiritual</option>
                                <option value="behavioral" {{ old('category') == 'behavioral' ? 'selected' : '' }}>Behavioral</option>
                                <option value="sleep" {{ old('category') == 'sleep' ? 'selected' : '' }}>Sleep Related</option>
                                <option value="digestive" {{ old('category') == 'digestive' ? 'selected' : '' }}>Digestive</option>
                                <option value="respiratory" {{ old('category') == 'respiratory' ? 'selected' : '' }}>Respiratory</option>
                                <option value="neurological" {{ old('category') == 'neurological' ? 'selected' : '' }}>Neurological</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_active">Status</label>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" 
                               class="form-check-input" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (Available for selection in treatments)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="form-control @error('description') is-invalid @enderror" 
                              placeholder="Detailed description of the symptom, its characteristics, and any relevant information">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Symptom
                    </button>
                    <a href="{{ route('superadmin.symptoms.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
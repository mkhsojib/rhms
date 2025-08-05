@extends('layouts.app')

@section('title', 'Edit Symptom')

@section('content_header')
    <h1>Edit Symptom</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.symptoms.update', $symptom) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Symptom Name *</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $symptom->name) }}" required>
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
                                <option value="physical" {{ old('category', $symptom->category) == 'physical' ? 'selected' : '' }}>Physical</option>
                                <option value="emotional_spiritual" {{ old('category', $symptom->category) == 'emotional_spiritual' ? 'selected' : '' }}>Emotional/Spiritual</option>
                                <option value="other" {{ old('category', $symptom->category) == 'other' ? 'selected' : '' }}>Other Potential Symptoms</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">Select Type (Optional)</option>
                                <option value="ruqiyah" {{ old('type', $symptom->type) == 'ruqiyah' ? 'selected' : '' }}>Ruqiyah</option>
                                <option value="hijama" {{ old('type', $symptom->type) == 'hijama' ? 'selected' : '' }}>Hijama</option>
                            </select>
                            <small class="form-text text-muted">Select type if applicable (mainly for Emotional/Spiritual symptoms)</small>
                            @error('type')
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
                               {{ old('is_active', $symptom->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (Available for selection in treatments)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="form-control @error('description') is-invalid @enderror" 
                              placeholder="Detailed description of the symptom, its characteristics, and any relevant information">{{ old('description', $symptom->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Symptom
                    </button>
                    <a href="{{ route('superadmin.symptoms.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
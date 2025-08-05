@extends('layouts.app')

@section('title', 'Symptom Details')

@section('content_header')
    <h1>Symptom Details</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $symptom->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.symptoms.edit', $symptom) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('superadmin.symptoms.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Category:</strong>
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $symptom->category)) }}</span>
                        </div>
                        @if($symptom->type)
                        <div class="col-md-4">
                            <strong>Type:</strong>
                            <span class="badge badge-warning">{{ ucfirst($symptom->type) }}</span>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <strong>Status:</strong>
                            @if($symptom->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($symptom->description)
                        <div class="mt-3">
                            <strong>Description:</strong>
                            <p class="mt-2">{{ $symptom->description }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Created:</strong>
                                <p>{{ $symptom->created_at->format('M d, Y \\a\\t h:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Last Updated:</strong>
                                <p>{{ $symptom->updated_at->format('M d, Y \\a\\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Treatment History</h3>
                </div>
                <div class="card-body">
                    @if($symptom->treatments->count() > 0)
                        <p><strong>Total Treatments:</strong> {{ $symptom->treatments->count() }}</p>
                        
                        <div class="list-group">
                            @foreach($symptom->treatments->take(5) as $treatment)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Treatment #{{ $treatment->id }}</h6>
                                        <small>{{ $treatment->created_at->format('M d, Y') }}</small>
                                    </div>
                                    @if($treatment->appointment && $treatment->appointment->patient)
                                        <p class="mb-1">Patient: {{ $treatment->appointment->patient->name }}</p>
                                    @endif
                                    <small>Type: {{ ucfirst($treatment->treatment_type) }}</small>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($symptom->treatments->count() > 5)
                            <p class="mt-2 text-muted">And {{ $symptom->treatments->count() - 5 }} more treatments...</p>
                        @endif
                    @else
                        <p class="text-muted">No treatments recorded for this symptom yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
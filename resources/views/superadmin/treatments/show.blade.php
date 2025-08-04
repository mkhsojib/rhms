@extends('layouts.app')

@section('title', 'Treatment Details')

@section('content_header')
    <h1>Treatment Details</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Treatment Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Treatment Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Treatment ID:</strong></td>
                                    <td>#{{ $treatment->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Appointment Number:</strong></td>
                                    <td>#{{ $treatment->appointment->appointment_no }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Treatment Type:</strong></td>
                                    <td>
                                        @switch($treatment->appointment->type)
                                            @case('ruqyah')
                                                <span class="badge badge-info">Ruqyah</span>
                                                @break
                                            @case('hijama')
                                                <span class="badge badge-warning">Hijama</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($treatment->appointment->type) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Treatment Date:</strong></td>
                                    <td>{{ $treatment->treatment_date->format('l, F d, Y') }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $treatment->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $treatment->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @if($treatment->createdBy)
                                <tr>
                                    <td><strong>Created By:</strong></td>
                                    <td>{{ $treatment->createdBy->name }} ({{ $treatment->createdBy->role }})</td>
                                </tr>
                                @endif
                                @if($treatment->updatedBy)
                                <tr>
                                    <td><strong>Last Updated By:</strong></td>
                                    <td>{{ $treatment->updatedBy->name }} ({{ $treatment->updatedBy->role }})</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($treatment->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Treatment Notes:</strong></h5>
                            <p class="text-muted">{{ $treatment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if($treatment->creation_notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Creation Notes:</strong></h5>
                            <div class="alert alert-success">
                                {{ $treatment->creation_notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($treatment->update_notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Update Notes:</strong></h5>
                            <div class="alert alert-warning">
                                {{ $treatment->update_notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Symptoms Section -->
                    @if($treatment->symptoms->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5><strong>Symptoms Addressed:</strong></h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Symptom</th>
                                            <th>Severity</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($treatment->symptoms as $symptom)
                                        <tr>
                                            <td>{{ $symptom->name }}</td>
                                            <td>
                                                @switch($symptom->pivot->severity)
                                                    @case('mild')
                                                        <span class="badge badge-success">Mild</span>
                                                        @break
                                                    @case('moderate')
                                                        <span class="badge badge-warning">Moderate</span>
                                                        @break
                                                    @case('severe')
                                                        <span class="badge badge-danger">Severe</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-secondary">{{ ucfirst($symptom->pivot->severity) }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $symptom->pivot->notes ?: '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Medicines Section -->
                    @if($treatment->medicines->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5><strong>Prescribed Medicines:</strong></h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Medicine</th>
                                            <th>Dosage</th>
                                            <th>Duration</th>
                                            <th>Timing</th>
                                            <th>Instructions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($treatment->medicines as $medicine)
                                        <tr>
                                            <td>{{ $medicine->name }}</td>
                                            <td>{{ $medicine->pivot->dosage ?: '-' }}</td>
                                            <td>{{ $medicine->pivot->duration_days }} days</td>
                                            <td>
                                                @php
                                                    $timings = [];
                                                    if($medicine->pivot->morning) $timings[] = 'Morning';
                                                    if($medicine->pivot->noon) $timings[] = 'Noon';
                                                    if($medicine->pivot->afternoon) $timings[] = 'Afternoon';
                                                    if($medicine->pivot->night) $timings[] = 'Night';
                                                @endphp
                                                {{ implode(', ', $timings) ?: '-' }}
                                            </td>
                                            <td>{{ $medicine->pivot->instructions ?: '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Appointment Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Related Appointment</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Appointment Date:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($treatment->appointment->appointment_date)->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Appointment Time:</strong></td>
                                    <td>{{ $treatment->appointment->appointment_time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @switch($treatment->appointment->status)
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
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($treatment->appointment->status) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($treatment->appointment->symptoms)
                            <h5><strong>Symptoms/Complaints:</strong></h5>
                            <p class="text-muted">{{ $treatment->appointment->symptoms }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Patient Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient Information</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="profile-user-img img-fluid img-circle" style="width: 80px; height: 80px; background-color: #17a2b8; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 32px; color: white; font-weight: bold;">
                            {{ strtoupper(substr($treatment->appointment->patient->name ?? 'N/A', 0, 1)) }}
                        </div>
                        <h5 class="mt-2">{{ $treatment->appointment->patient->name ?? 'N/A' }}</h5>
                        <p class="text-muted">{{ $treatment->appointment->patient->email ?? 'N/A' }}</p>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $treatment->appointment->patient->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $treatment->appointment->patient->address ?? 'Not provided' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Practitioner Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Practitioner Information</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="profile-user-img img-fluid img-circle" style="width: 80px; height: 80px; background-color: #ffc107; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 32px; color: white; font-weight: bold;">
                            {{ strtoupper(substr($treatment->appointment->practitioner->name ?? 'N/A', 0, 1)) }}
                        </div>
                        <h5 class="mt-2">{{ $treatment->appointment->practitioner->name ?? 'N/A' }}</h5>
                        <p class="text-muted">{{ $treatment->appointment->practitioner->email ?? 'N/A' }}</p>
                        @if($treatment->appointment->practitioner->specialization)
                            <span class="badge badge-light">{{ $treatment->appointment->practitioner->specialization_label }}</span>
                        @endif
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $treatment->appointment->practitioner->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $treatment->appointment->practitioner->address ?? 'Not provided' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('superadmin.treatments.edit', $treatment) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Treatment
                        </a>
                        
                        <form action="{{ route('superadmin.treatments.destroy', $treatment) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this treatment record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                    
                    <a href="{{ route('superadmin.treatments.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Treatments
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .profile-user-img {
        border: 3px solid #adb5bd;
    }
</style>
@stop
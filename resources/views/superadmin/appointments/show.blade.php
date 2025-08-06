@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content_header')
    <h1>Appointment Details</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Appointment Details -->
            <div class="card">
                            <div class="card-header">
                <h3 class="card-title">
                    Appointment Information
                    <small class="text-muted ml-2">({{ $appointment->appointment_no }})</small>
                </h3>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Appointment ID:</strong></td>
                                    <td>#{{ $appointment->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Treatment Type:</strong></td>
                                    <td>
                                        @switch($appointment->type)
                                            @case('ruqyah')
                                                <span class="badge badge-info">Ruqyah</span>
                                                @break
                                            @case('hijama')
                                                <span class="badge badge-warning">Hijama</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($appointment->type) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Time:</strong></td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
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
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($appointment->status) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Session Type:</strong></td>
                                    <td>
                                        @if($appointment->type === 'hijama')
                                            {{-- Display Head Cupping pricing from appointments table --}}
                                            @if($appointment->head_cupping_fee)
                                                <div class="mb-2">
                                                    <strong>Head Cupping</strong>
                                                    <br><span class="text-success font-weight-bold">Estimate Per Cup: ${{ number_format($appointment->head_cupping_fee, 2) }}</span>
                                                </div>
                                            @endif
                                            
                                            {{-- Display Body Cupping pricing from appointments table --}}
                                            @if($appointment->body_cupping_fee)
                                                <div class="mb-2">
                                                    <strong>Body Cupping</strong>
                                                    <br><span class="text-success font-weight-bold">Estimate Per Cup: ${{ number_format($appointment->body_cupping_fee, 2) }}</span>
                                                </div>
                                            @endif
                                            
                                            {{-- Fallback if no Hijama pricing is stored --}}
                                            @if(!$appointment->head_cupping_fee && !$appointment->body_cupping_fee)
                                                <span class="text-muted">No Hijama pricing available</span>
                                            @endif
                                        @else
                                            @php
                                                $stypeName = $appointment->session_type_name ?? $appointment->sessionType->type ?? null;
                                                $stypeFee = $appointment->session_type_fee ?? $appointment->sessionType->fee ?? null;
                                                $stypeMin = $appointment->session_type_min_duration ?? $appointment->sessionType->min_duration ?? null;
                                                $stypeMax = $appointment->session_type_max_duration ?? $appointment->sessionType->max_duration ?? null;
                                            @endphp
                                            @if($stypeName)
                                                <strong>{{ ucwords(str_replace('_', ' ', $stypeName)) }}</strong>
                                                @if($stypeFee)
                                                    <br>Fee: <span class="text-success">${{ number_format($stypeFee, 2) }}</span>
                                                @endif
                                                @if($stypeMin && $stypeMax)
                                                    <br>Duration: <span class="text-primary">{{ $stypeMin }}-{{ $stypeMax }} min</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $appointment->created_at ? \Carbon\Carbon::parse($appointment->created_at)->format('M d, Y H:i') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $appointment->updated_at ? \Carbon\Carbon::parse($appointment->updated_at)->format('M d, Y H:i') : 'N/A' }}</td>
                                </tr>
                                @if($appointment->createdBy)
                                <tr>
                                    <td><strong>Created By:</strong></td>
                                    <td>{{ $appointment->createdBy->name }} ({{ $appointment->createdBy->role }})</td>
                                </tr>
                                @endif
                                @if($appointment->updatedBy)
                                <tr>
                                    <td><strong>Last Updated By:</strong></td>
                                    <td>{{ $appointment->updatedBy->name }} ({{ $appointment->updatedBy->role }})</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($appointment->symptoms)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Symptoms/Complaints:</strong></h5>
                            <p class="text-muted">{{ $appointment->symptoms }}</p>
                        </div>
                    </div>
                    @endif

                    @if($appointment->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Notes:</strong></h5>
                            <p class="text-muted">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if($appointment->status === 'approved' && $appointment->approvedBy)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Approval Information:</strong></h5>
                            <div class="alert alert-success">
                                <strong>Approved by:</strong> {{ $appointment->approvedBy->name }} ({{ $appointment->approvedBy->role }})<br>
                                <strong>Approved on:</strong> {{ $appointment->approved_at ? \Carbon\Carbon::parse($appointment->approved_at)->format('M d, Y g:i A') : 'N/A' }}
                                @if($appointment->approval_notes)
                                <br><strong>Notes:</strong> {{ $appointment->approval_notes }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($appointment->status === 'rejected' && $appointment->rejectedBy)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Rejection Information:</strong></h5>
                            <div class="alert alert-danger">
                                <strong>Rejected by:</strong> {{ $appointment->rejectedBy->name }} ({{ $appointment->rejectedBy->role }})<br>
                                <strong>Rejected on:</strong> {{ $appointment->rejected_at ? \Carbon\Carbon::parse($appointment->rejected_at)->format('M d, Y g:i A') : 'N/A' }}
                                @if($appointment->rejection_reason)
                                <br><strong>Reason:</strong> {{ $appointment->rejection_reason }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if($appointment->invoice)
                <div class="mb-4 d-flex justify-content-center">
                    @if($appointment->invoice->status === 'paid')
                        <a href="{{ route('superadmin.invoices.print', $appointment->invoice) }}" class="btn btn-primary mx-2" target="_blank">
                            <i class="fas fa-print"></i> Print Invoice
                        </a>
                        <a href="{{ route('superadmin.invoices.download', $appointment->invoice) }}" class="btn btn-success mx-2" target="_blank">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
                    @else
                        <a href="{{ route('superadmin.invoices.payPage', $appointment->invoice) }}" class="btn btn-warning mx-2">
                            <i class="fas fa-credit-card"></i> Pay Now
                        </a>
                    @endif
                </div>
            @endif
            
            @if($appointment->treatment)
                <div class="mb-4 d-flex justify-content-center">
                    <a href="{{ route('superadmin.treatments.prescription', $appointment->treatment) }}" class="btn btn-info mx-2" target="_blank">
                        <i class="fas fa-eye"></i> View Prescription
                    </a>
                    <a href="{{ route('superadmin.treatments.prescription.pdf', $appointment->treatment) }}" class="btn btn-danger mx-2">
                        <i class="fas fa-file-pdf"></i> Download Prescription PDF
                    </a>
                </div>
            @endif
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
                            {{ strtoupper(substr($appointment->patient->name ?? 'N/A', 0, 1)) }}
                        </div>
                        <h5 class="mt-2">{{ $appointment->patient->name ?? 'N/A' }}</h5>
                        <p class="text-muted">{{ $appointment->patient->email ?? 'N/A' }}</p>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $appointment->patient->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $appointment->patient->address ?? 'Not provided' }}</td>
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
                            {{ strtoupper(substr($appointment->practitioner->name ?? 'N/A', 0, 1)) }}
                        </div>
                        <h5 class="mt-2">{{ $appointment->practitioner->name ?? 'N/A' }}</h5>
                        <p class="text-muted">{{ $appointment->practitioner->email ?? 'N/A' }}</p>
                        @if($appointment->practitioner->specialization)
                            <span class="badge badge-light">{{ $appointment->practitioner->specialization_label }}</span>
                        @endif
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $appointment->practitioner->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $appointment->practitioner->address ?? 'Not provided' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Treatment Information -->
    @if($appointment->treatment)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Treatment Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Treatment Date:</strong></td>
                                    <td>{{ $appointment->treatment && $appointment->treatment->treatment_date ? \Carbon\Carbon::parse($appointment->treatment->treatment_date)->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Duration:</strong></td>
                                    <td>{{ $appointment->treatment->duration }} minutes</td>
                                </tr>
                                <tr>
                                    <td><strong>Cost:</strong></td>
                                    <td>${{ number_format($appointment->treatment->cost, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($appointment->treatment->notes)
                            <h5><strong>Treatment Notes:</strong></h5>
                            <p class="text-muted">{{ $appointment->treatment->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescription Details -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-prescription-bottle-alt"></i> Prescription Details
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Symptoms/Chief Complaints -->
                    @if($appointment->treatment->symptoms && $appointment->treatment->symptoms->count() > 0)
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-stethoscope"></i> Chief Complaints & Symptoms</h5>
                        <div class="row">
                            @foreach($appointment->treatment->symptoms as $symptom)
                            <div class="col-md-6 mb-3">
                                <div class="card border-left-danger">
                                    <div class="card-body py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 text-danger">{{ $symptom->name }}</h6>
                                                <span class="badge badge-{{ $symptom->pivot->severity === 'severe' ? 'danger' : ($symptom->pivot->severity === 'moderate' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($symptom->pivot->severity ?? 'moderate') }}
                                                </span>
                                            </div>
                                        </div>
                                        @if($symptom->pivot->notes)
                                        <p class="text-muted small mt-2 mb-0">{{ $symptom->pivot->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Prescribed Medicines -->
                    @if($appointment->treatment->medicines && $appointment->treatment->medicines->count() > 0)
                    <div class="mb-4">
                        <h5 class="text-success"><i class="fas fa-pills"></i> Prescribed Medicines</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Dosage</th>
                                        <th>Timing</th>
                                        <th>Duration</th>
                                        <th>Instructions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointment->treatment->medicines as $medicine)
                                    <tr>
                                        <td>
                                            <strong>{{ $medicine->name }}</strong>
                                            @if($medicine->generic_name)
                                            <br><small class="text-muted">{{ $medicine->generic_name }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $medicine->pivot->dosage ?? 'As prescribed' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @if($medicine->pivot->morning)
                                                <span class="badge badge-warning">Morning</span>
                                                @endif
                                                @if($medicine->pivot->noon)
                                                <span class="badge badge-primary">Noon</span>
                                                @endif
                                                @if($medicine->pivot->afternoon)
                                                <span class="badge badge-secondary">Afternoon</span>
                                                @endif
                                                @if($medicine->pivot->night)
                                                <span class="badge badge-dark">Night</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-primary">{{ $medicine->pivot->duration_days ?? 7 }} days</span>
                                        </td>
                                        <td>
                                            <small>{{ $medicine->pivot->instructions ?? 'Take as directed' }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Prescription Text -->
                    @if($appointment->treatment->prescription)
                    <div class="mb-4">
                        <h5 class="text-info"><i class="fas fa-file-prescription"></i> Additional Prescription Notes</h5>
                        <div class="alert alert-light border-left-info">
                            <p class="mb-0">{{ $appointment->treatment->prescription }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Aftercare Instructions -->
                    @if($appointment->treatment->aftercare)
                    <div class="mb-4">
                        <h5 class="text-warning"><i class="fas fa-heart"></i> Aftercare Instructions</h5>
                        <div class="alert alert-warning">
                            <p class="mb-0">{{ $appointment->treatment->aftercare }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- No Prescription Message -->
                    @if((!$appointment->treatment->symptoms || $appointment->treatment->symptoms->count() === 0) && 
                         (!$appointment->treatment->medicines || $appointment->treatment->medicines->count() === 0) && 
                         !$appointment->treatment->prescription && 
                         !$appointment->treatment->aftercare)
                    <div class="text-center py-4">
                        <i class="fas fa-prescription-bottle-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No prescription details available</h5>
                        <p class="text-muted">Prescription information will appear here once the treatment is completed.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($questions->count())
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient Questionnaire</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td>{{ $question->question_text }}</td>
                                <td>
                                    @php $answer = $answers[$question->id] ?? null; @endphp
                                    @if($answer === null || $answer === '')
                                        <span class="text-muted">Not answered</span>
                                    @elseif($question->input_type === 'checkbox')
                                        @foreach(json_decode($answer, true) ?? [] as $val)
                                            <span class="badge badge-info mr-1">{{ $val }}</span>
                                        @endforeach
                                    @else
                                        {{ $answer }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($appointment->status !== 'completed')
                <div class="mt-3">
                    <a href="{{ route('superadmin.appointments.questions.edit', $appointment) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Answers
                    </a>
                </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('superadmin.appointments.questions.download', $appointment) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-file-pdf"></i> Download Answers PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('superadmin.appointments.edit', $appointment) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Appointment
                        </a>
                        
                        @if($appointment->status === 'pending')
                            <button type="button" class="btn btn-success" 
                                    data-toggle="modal" data-target="#approveModal">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button type="button" class="btn btn-danger" 
                                    data-toggle="modal" data-target="#rejectModal">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        @endif
                        
                        @if($appointment->status === 'approved')
                            <form action="{{ route('superadmin.appointments.complete', $appointment) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" 
                                        onclick="return confirm('Mark this appointment as completed?')">
                                    <i class="fas fa-check-double"></i> Mark Complete
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('superadmin.appointments.destroy', $appointment) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                    
                    <a href="{{ route('superadmin.appointments.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Appointments
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

<!-- Approve Modal -->
@if($appointment->status === 'pending')
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('superadmin.appointments.approve', $appointment) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Approve Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this appointment?</p>
                    <div class="form-group">
                        <label for="approval_notes">Approval Notes (Optional)</label>
                        <textarea class="form-control" id="approval_notes" name="approval_notes" rows="3" 
                                  placeholder="Add any notes about this approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('superadmin.appointments.reject', $appointment) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Reject Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this appointment?</p>
                    <div class="form-group">
                        <label for="rejection_reason">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" 
                                  placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@extends('layouts.app')

@section('title', 'Appointment Details')

@section('page-title', 'Appointment Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Appointment #{{ $appointment->id }}
                    <small class="text-muted ml-2">({{ $appointment->appointment_no }})</small>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Patient Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $appointment->patient->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $appointment->patient->email }}</td>
                            </tr>
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
                    <div class="col-md-6">
                        <h5>Appointment Details</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Appointment No:</strong></td>
                                <td><span class="badge badge-primary">{{ $appointment->appointment_no }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $appointment->type === 'ruqyah' ? 'info' : 'warning' }}">
                                        {{ ucfirst($appointment->type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Time:</strong></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    @if($appointment->appointment_end_time)
                                        - {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('g:i A') }}
                                    @endif
                                </td>
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
                                                <br><span class="text-success font-weight-bold">Estimate Per Cup: {{ number_format($appointment->head_cupping_fee, 2) }}</span>
                                            </div>
                                        @endif
                                        
                                        {{-- Display Body Cupping pricing from appointments table --}}
                                        @if($appointment->body_cupping_fee)
                                            <div class="mb-2">
                                                <strong>Body Cupping</strong>
                                                <br><span class="text-success font-weight-bold">Estimate Per Cup: {{ number_format($appointment->body_cupping_fee, 2) }}</span>
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
                                                &mdash; Fee: <span class="text-success">{{ number_format($stypeFee, 2) }}</span>
                                            @endif
                                            @if($stypeMin && $stypeMax)
                                                &mdash; Duration: <span class="text-primary">{{ $stypeMin }}-{{ $stypeMax }} min</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td>{{ $appointment->created_at ? \Carbon\Carbon::parse($appointment->created_at)->format('M d, Y g:i A') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Updated:</strong></td>
                                <td>{{ $appointment->updated_at ? \Carbon\Carbon::parse($appointment->updated_at)->format('M d, Y g:i A') : 'N/A' }}</td>
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
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Symptoms/Notes from Patient</h5>
                        <div class="alert alert-info">
                            {{ $appointment->symptoms }}
                        </div>
                    </div>
                </div>
                @endif

                @if($appointment->notes)
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Practitioner Notes</h5>
                        <div class="alert alert-warning">
                            {{ $appointment->notes }}
                        </div>
                    </div>
                </div>
                @endif

                @if($appointment->status === 'approved' && $appointment->approvedBy)
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Approval Information</h5>
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
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Rejection Information</h5>
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
                @if($appointment->invoice)
                    <div class="mb-4 d-flex justify-content-center">
                        @if($appointment->invoice->status === 'paid')
                            <a href="{{ route('admin.invoices.print', $appointment->invoice) }}" class="btn btn-primary mx-2" target="_blank">
                                <i class="fas fa-print"></i> Print Invoice
                            </a>
                            <a href="{{ route('admin.invoices.download', $appointment->invoice) }}" class="btn btn-success mx-2" target="_blank">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        @else
                            <a href="{{ route('admin.invoices.payPage', $appointment->invoice) }}" class="btn btn-warning mx-2">
                                <i class="fas fa-credit-card"></i> Pay Now
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Appointment
                    </a>

                    @if($appointment->status === 'pending')
                        <button type="button" class="btn btn-success btn-block" 
                                data-toggle="modal" data-target="#approveModal">
                            <i class="fas fa-check"></i> Approve Appointment
                        </button>

                        <button type="button" class="btn btn-danger btn-block" 
                                data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Appointment
                        </button>
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

                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" 
                                onclick="return confirm('Delete this appointment? This action cannot be undone.')">
                            <i class="fas fa-trash"></i> Delete Appointment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($appointment->treatment)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Treatment Record</h3>
            </div>
            <div class="card-body">
                <p><strong>Treatment Date:</strong> {{ $appointment->treatment->treatment_date->format('M d, Y') }}</p>
                <p><strong>Duration:</strong> {{ $appointment->treatment->duration }} minutes</p>
                <p><strong>Notes:</strong> {{ $appointment->treatment->notes ?? 'No notes' }}</p>
                <a href="{{ route('admin.treatments.show', $appointment->treatment) }}" 
                   class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> View Treatment Details
                </a>
            </div>
        </div>
        @else
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Treatment Record</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">No treatment record found for this appointment.</p>
                @if($appointment->status === 'approved')
                    <a href="{{ route('admin.treatments.create', ['appointment_id' => $appointment->id]) }}" 
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Create Treatment Record
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Approve Modal -->
@if($appointment->status === 'pending')
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST">
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
            <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST">
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
                    <a href="{{ route('admin.appointments.questions.edit', $appointment) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Answers
                    </a>
                </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('admin.appointments.questions.download', $appointment) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-file-pdf"></i> Download Answers PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection 
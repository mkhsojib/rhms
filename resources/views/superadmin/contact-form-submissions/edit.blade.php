@extends('layouts.app')

@section('title', 'Edit Contact Form Submission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Contact Form Submission</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.contact-form-submissions.show', $contactFormSubmission->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Details
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.contact-form-submissions.update', $contactFormSubmission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Submission Information (Read Only)</h4>
                                
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" value="{{ $contactFormSubmission->full_name }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $contactFormSubmission->email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" value="{{ $contactFormSubmission->phone }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $contactFormSubmission->message }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Submitted At</label>
                                    <input type="text" class="form-control" value="{{ $contactFormSubmission->created_at->format('F d, Y \a\t g:i A') }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4>Admin Management</h4>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="new" {{ old('status', $contactFormSubmission->status) == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="read" {{ old('status', $contactFormSubmission->status) == 'read' ? 'selected' : '' }}>Read</option>
                                        <option value="replied" {{ old('status', $contactFormSubmission->status) == 'replied' ? 'selected' : '' }}>Replied</option>
                                        <option value="archived" {{ old('status', $contactFormSubmission->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="admin_notes">Admin Notes</label>
                                    <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                              id="admin_notes" name="admin_notes" rows="6" 
                                              placeholder="Add any internal notes about this submission...">{{ old('admin_notes', $contactFormSubmission->admin_notes) }}</textarea>
                                    @error('admin_notes')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        These notes are only visible to administrators and will not be shared with the customer.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label>Current Status</label>
                                    <div>
                                        <span class="{{ $contactFormSubmission->status_badge_class }}">
                                            {{ $contactFormSubmission->status_text }}
                                        </span>
                                    </div>
                                </div>

                                @if($contactFormSubmission->read_at)
                                <div class="form-group">
                                    <label>Read At</label>
                                    <input type="text" class="form-control" value="{{ $contactFormSubmission->read_at->format('F d, Y \a\t g:i A') }}" readonly>
                                </div>
                                @endif

                                @if($contactFormSubmission->replied_at)
                                <div class="form-group">
                                    <label>Replied At</label>
                                    <input type="text" class="form-control" value="{{ $contactFormSubmission->replied_at->format('F d, Y \a\t g:i A') }}" readonly>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Submission
                                </button>
                                <a href="{{ route('superadmin.contact-form-submissions.show', $contactFormSubmission->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('title', 'View Contact Form Submission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Form Submission Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.contact-form-submissions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Submission Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="150">Full Name:</th>
                                            <td>{{ $submission->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>
                                                <a href="tel:{{ $submission->phone }}">{{ $submission->phone }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span class="{{ $submission->status_badge_class }}">
                                                    {{ $submission->status_text }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Submitted:</th>
                                            <td>{{ $submission->created_at->format('F d, Y \a\t g:i A') }}</td>
                                        </tr>
                                        @if($submission->read_at)
                                        <tr>
                                            <th>Read At:</th>
                                            <td>{{ $submission->read_at->format('F d, Y \a\t g:i A') }}</td>
                                        </tr>
                                        @endif
                                        @if($submission->replied_at)
                                        <tr>
                                            <th>Replied At:</th>
                                            <td>{{ $submission->replied_at->format('F d, Y \a\t g:i A') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4>Message</h4>
                                </div>
                                <div class="card-body">
                                    <div class="bg-light p-3 rounded">
                                        {{ $submission->message }}
                                    </div>
                                </div>
                            </div>

                            @if($submission->admin_notes)
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4>Admin Notes</h4>
                                </div>
                                <div class="card-body">
                                    <div class="bg-warning p-3 rounded">
                                        {{ $submission->admin_notes }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Quick Actions</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($submission->status === 'new')
                                        <form action="{{ route('superadmin.contact-form-submissions.mark-read', $submission->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-check"></i> Mark as Read
                                            </button>
                                        </form>
                                        @endif

                                        @if($submission->status !== 'replied')
                                        <form action="{{ route('superadmin.contact-form-submissions.mark-replied', $submission->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-block">
                                                <i class="fas fa-reply"></i> Mark as Replied
                                            </button>
                                        </form>
                                        @endif

                                        <a href="{{ route('superadmin.contact-form-submissions.edit', $submission->id) }}" class="btn btn-warning btn-block">
                                            <i class="fas fa-edit"></i> Edit Submission
                                        </a>

                                        <a href="mailto:{{ $submission->email }}?subject=Re: Your Contact Form Submission" class="btn btn-info btn-block">
                                            <i class="fas fa-envelope"></i> Reply via Email
                                        </a>

                                        <form action="{{ route('superadmin.contact-form-submissions.destroy', $submission->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-block">
                                                <i class="fas fa-trash"></i> Delete Submission
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
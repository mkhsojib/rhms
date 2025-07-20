@extends('layouts.app')

@section('title', 'Contact Form Submissions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Form Submissions</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.contact-form-submissions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Submission
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

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $stats['total'] }}</h3>
                                    <p>Total Submissions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $stats['new'] }}</h3>
                                    <p>New Submissions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $stats['read'] }}</h3>
                                    <p>Read Submissions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $stats['replied'] }}</h3>
                                    <p>Replied Submissions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-reply"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('superadmin.contact-form-submissions.filter') }}" method="GET" class="form-inline">
                                <div class="form-group mr-2">
                                    <label for="status" class="mr-2">Filter by Status:</label>
                                    <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All</option>
                                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Submissions Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td>
                                    <td>{{ $submission->full_name }}</td>
                                    <td>{{ $submission->email }}</td>
                                    <td>{{ $submission->phone }}</td>
                                    <td>
                                        {{ Str::limit($submission->message, 50) }}
                                        @if(strlen($submission->message) > 50)
                                            <a href="#" data-toggle="modal" data-target="#messageModal{{ $submission->id }}">
                                                Read More
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="{{ $submission->status_badge_class }}">
                                            {{ $submission->status_text }}
                                        </span>
                                    </td>
                                    <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('superadmin.contact-form-submissions.show', $submission->id) }}" 
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('superadmin.contact-form-submissions.edit', $submission->id) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($submission->status === 'new')
                                            <form action="{{ route('superadmin.contact-form-submissions.mark-read', $submission->id) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-primary" title="Mark as Read">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @if($submission->status !== 'replied')
                                            <form action="{{ route('superadmin.contact-form-submissions.mark-replied', $submission->id) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="Mark as Replied">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('superadmin.contact-form-submissions.destroy', $submission->id) }}" 
                                                  method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Message Modal -->
                                <div class="modal fade" id="messageModal{{ $submission->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Message from {{ $submission->full_name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $submission->message }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No submissions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
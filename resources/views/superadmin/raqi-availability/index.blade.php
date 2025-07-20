@extends('layouts.app')

@section('title', 'Raqis Available Time')

@section('content_header')
    <h1>Raqis Available Time</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Raqis Availability</h3>
            <div class="card-tools">
                <a href="{{ route('superadmin.raqi-availability.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Availability
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Raqi Name</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Slot Duration</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availabilities as $availability)
                            <tr>
                                <td>{{ $availability->id }}</td>
                                <td>
                                    <strong>{{ $availability->practitioner->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $availability->practitioner->email }}</small>
                                </td>
                                <td>
                                    {{ $availability->availability_date->format('M d, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $availability->availability_date->format('l') }}</small>
                                </td>
                                <td>{{ $availability->start_time }}</td>
                                <td>{{ $availability->end_time }}</td>
                                <td>{{ $availability->slot_duration }} minutes</td>
                                <td>
                                    @if($availability->is_available)
                                        <span class="badge badge-success">Available</span>
                                    @else
                                        <span class="badge badge-danger">Not Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if($availability->notes)
                                        <span class="text-muted">{{ Str::limit($availability->notes, 50) }}</span>
                                    @else
                                        <span class="text-muted">No notes</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('superadmin.raqi-availability.show', $availability) }}" 
                                           class="btn btn-info btn-sm" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.raqi-availability.edit', $availability) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('superadmin.raqi-availability.destroy', $availability) }}" 
                                              method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this availability?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No availability records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($availabilities->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $availabilities->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Card -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Raqis</span>
                    <span class="info-box-number">{{ $practitioners->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-calendar-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Available Days</span>
                    <span class="info-box-number">{{ $availableDays }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-calendar-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Unavailable Days</span>
                    <span class="info-box-number">{{ $unavailableDays }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Records</span>
                    <span class="info-box-number">{{ $totalAvailabilities }}</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .table th {
        background-color: #f4f6f9;
        border-color: #dee2e6;
    }
    .btn-group .btn {
        margin-right: 2px;
    }
    .info-box {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: 0.25rem;
        background-color: #fff;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        position: relative;
        width: 100%;
    }
    .info-box-icon {
        border-radius: 0.25rem 0 0 0.25rem;
        display: flex;
        align-items: center;
        font-size: 1.875rem;
        font-weight: 700;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: #fff;
    }
    .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.8;
        flex: 1;
        padding: 0 10px;
    }
    .info-box-text {
        display: block;
        font-size: 1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .info-box-number {
        display: block;
        font-weight: 700;
        font-size: 1.25rem;
    }
</style>
@stop 
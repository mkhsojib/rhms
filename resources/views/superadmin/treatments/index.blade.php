@extends('layouts.app')

@section('title', 'All Treatments')

@section('content_header')
    <h1>All Treatments</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $treatments->where('outcome', 'successful')->count() }}</h3>
                    <p>Successful</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $treatments->where('outcome', 'partial')->count() }}</h3>
                    <p>Partial</p>
                </div>
                <div class="icon">
                    <i class="fas fa-minus-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $treatments->where('outcome', 'unsuccessful')->count() }}</h3>
                    <p>Unsuccessful</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>${{ number_format($treatments->sum('cost'), 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">All Treatments</h3>
            <a href="{{ route('superadmin.treatments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Treatment
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Practitioner</th>
                            <th>Treatment Type</th>
                            <th>Date</th>
                            <th>Duration</th>
                            <th>Cost</th>
                            <th>Outcome</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($treatments as $treatment)
                            <tr>
                                <td>{{ $treatment->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="avatar-title bg-info rounded-circle">
                                                {{ strtoupper(substr($treatment->appointment->patient->name ?? 'N/A', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $treatment->appointment->patient->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $treatment->appointment->patient->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="avatar-title bg-warning rounded-circle">
                                                {{ strtoupper(substr($treatment->appointment->practitioner->name ?? 'N/A', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $treatment->appointment->practitioner->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $treatment->appointment->practitioner->specialization_label ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
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
                                <td>{{ $treatment->treatment_date->format('M d, Y') }}</td>
                                <td>{{ $treatment->duration }} min</td>
                                <td>${{ number_format($treatment->cost, 2) }}</td>
                                <td>
                                    @switch($treatment->outcome)
                                        @case('successful')
                                            <span class="badge badge-success">Successful</span>
                                            @break
                                        @case('partial')
                                            <span class="badge badge-warning">Partial</span>
                                            @break
                                        @case('unsuccessful')
                                            <span class="badge badge-danger">Unsuccessful</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ ucfirst($treatment->outcome) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('superadmin.treatments.show', $treatment) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.treatments.edit', $treatment) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('superadmin.treatments.destroy', $treatment) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this treatment record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No treatments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($treatments->hasPages())
                <div class="mt-3">
                    {{ $treatments->links() }}
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
</style>
@stop 
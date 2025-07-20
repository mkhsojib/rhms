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
            <!-- Raqis Overview -->
            <div class="row mb-4">
                @foreach($practitioners as $practitioner)
                    @php
                        // We need to get the availability data for each practitioner
                        $practitionerAvailabilities = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $practitioner->id)
                            ->where('availability_date', '>=', \Carbon\Carbon::now()->format('Y-m-d'))
                            ->where('availability_date', '<=', \Carbon\Carbon::now()->addMonth()->format('Y-m-d'))
                            ->get();
                        $availableCount = $practitionerAvailabilities->where('is_available', true)->count();
                        $unavailableCount = $practitionerAvailabilities->where('is_available', false)->count();
                    @endphp
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $practitioner->name }}</h5>
                                <p class="card-text text-muted">{{ $practitioner->email }}</p>
                                @if($practitioner->specialization)
                                    <span class="badge badge-info mb-2">{{ $practitioner->specialization_label }}</span>
                                @endif
                                <div class="row text-center">
                                    <div class="col-6">
                                        <small class="text-success">Available: {{ $availableCount }}</small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-warning">Unavailable: {{ $unavailableCount }}</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('superadmin.raqi-availability.by-practitioner', $practitioner->id) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> View Availability
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

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
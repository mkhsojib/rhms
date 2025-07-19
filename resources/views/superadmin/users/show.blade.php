@extends('layouts.app')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <!-- User Profile Card -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="profile-user-img img-fluid img-circle" style="width: 100px; height: 100px; background-color: #007bff; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 40px; color: white; font-weight: bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">
                        @switch($user->role)
                            @case('super_admin')
                                <span class="badge badge-danger">Super Admin</span>
                                @break
                            @case('admin')
                                <span class="badge badge-warning">Admin (Raqi)</span>
                                @break
                            @case('patient')
                                <span class="badge badge-info">Patient</span>
                                @break
                            @default
                                <span class="badge badge-secondary">{{ ucfirst($user->role) }}</span>
                        @endswitch
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email Status</b> 
                            <span class="float-right">
                                @if($user->email_verified_at)
                                    <span class="badge badge-success">Verified</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since</b> 
                            <span class="float-right">{{ $user->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Last Updated</b> 
                            <span class="float-right">{{ $user->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>

                    <div class="text-center">
                        <a href="{{ route('superadmin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('superadmin.users.destroy', $user) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- User Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email Address:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        @switch($user->role)
                                            @case('super_admin')
                                                <span class="badge badge-danger">Super Admin</span>
                                                @break
                                            @case('admin')
                                                <span class="badge badge-warning">Admin (Raqi)</span>
                                                @break
                                            @case('patient')
                                                <span class="badge badge-info">Patient</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($user->role) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                @if($user->specialization)
                                <tr>
                                    <td><strong>Specialization:</strong></td>
                                    <td>{{ $user->specialization_label }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Phone Number:</strong></td>
                                    <td>{{ $user->phone ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email Verified:</strong></td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Yes ({{ $user->email_verified_at->format('M d, Y H:i') }})</span>
                                        @else
                                            <span class="badge badge-warning">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created At:</strong></td>
                                    <td>{{ $user->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated At:</strong></td>
                                    <td>{{ $user->updated_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($user->address)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5><strong>Address:</strong></h5>
                            <p class="text-muted">{{ $user->address }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- User Statistics -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($user->isPatient())
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Appointments</span>
                                        <span class="info-box-number">{{ $user->patientAppointments()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Completed</span>
                                        <span class="info-box-number">{{ $user->patientAppointments()->where('status', 'completed')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pending</span>
                                        <span class="info-box-number">{{ $user->patientAppointments()->where('status', 'pending')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->isAdmin())
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Appointments</span>
                                        <span class="info-box-number">{{ $user->practitionerAppointments()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Completed</span>
                                        <span class="info-box-number">{{ $user->practitionerAppointments()->where('status', 'completed')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pending</span>
                                        <span class="info-box-number">{{ $user->practitionerAppointments()->where('status', 'pending')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Practitioner Pricing (Session/Cupping Fees) -->
            @if($user->isAdmin())
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Session & Cupping Fees</h3>
                </div>
                <div class="card-body">
                    @php
                        $fees = $user->sessionTypes->keyBy('type');
                        $currency = \App\Models\Setting::getValue('currency_symbol', '$');
                    @endphp
                    <div class="row">
                        @if($user->specialization === 'ruqyah_healing' || $user->specialization === 'both')
                            <div class="col-md-4">
                                <strong>Diagnosis Session:</strong><br>
                                @if(isset($fees['diagnosis']))
                                    {{ $currency }}{{ number_format($fees['diagnosis']->fee, 2) }}
                                    <small class="text-muted">({{ $fees['diagnosis']->min_duration }}-{{ $fees['diagnosis']->max_duration }} min)</small>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <strong>Short Session:</strong><br>
                                @if(isset($fees['short']))
                                    {{ $currency }}{{ number_format($fees['short']->fee, 2) }}
                                    <small class="text-muted">({{ $fees['short']->min_duration }}-{{ $fees['short']->max_duration }} min)</small>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <strong>Long Session:</strong><br>
                                @if(isset($fees['long']))
                                    {{ $currency }}{{ number_format($fees['long']->fee, 2) }}
                                    <small class="text-muted">({{ $fees['long']->min_duration }}-{{ $fees['long']->max_duration }} min)</small>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </div>
                        @endif
                        @if($user->specialization === 'hijama_cupping' || $user->specialization === 'both')
                            <div class="col-md-6 mt-3">
                                <strong>Head Cupping (per point):</strong><br>
                                @if(isset($fees['head_cupping']))
                                    {{ $currency }}{{ number_format($fees['head_cupping']->fee, 2) }}
                                    <small class="text-muted">({{ $fees['head_cupping']->min_duration }}-{{ $fees['head_cupping']->max_duration }} min)</small>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </div>
                            <div class="col-md-6 mt-3">
                                <strong>Body Cupping (per point):</strong><br>
                                @if(isset($fees['body_cupping']))
                                    {{ $currency }}{{ number_format($fees['body_cupping']->fee, 2) }}
                                    <small class="text-muted">({{ $fees['body_cupping']->min_duration }}-{{ $fees['body_cupping']->max_duration }} min)</small>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    <td><span class="badge badge-success">Account Created</span></td>
                                    <td>User account was created</td>
                                </tr>
                                @if($user->email_verified_at)
                                <tr>
                                    <td>{{ $user->email_verified_at->format('M d, Y H:i') }}</td>
                                    <td><span class="badge badge-info">Email Verified</span></td>
                                    <td>Email address was verified</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                    <td><span class="badge badge-warning">Profile Updated</span></td>
                                    <td>Profile information was last updated</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>
@stop

@section('css')
<style>
    .profile-user-img {
        border: 3px solid #adb5bd;
    }
    .info-box {
        min-height: 80px;
    }
    .info-box-icon {
        border-radius: 0.25rem;
    }
</style>
@stop 
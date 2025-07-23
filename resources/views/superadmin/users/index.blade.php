@extends('layouts.app')

@section('title', 'User Management')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">All Users</h3>
            <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
        
        <!-- Search Form Toggle Button -->
        <div class="card-header border-bottom">
            <button type="button" class="btn btn-sm btn-outline-primary" id="toggleSearchForm">
                <i class="fas fa-search"></i> Show Search Options
            </button>
        </div>
        
        <!-- Search Form -->
        <div class="card-body border-bottom" id="searchFormContainer" style="display: none;">
            <form action="{{ route('superadmin.users.index') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control form-control-sm" value="{{ request('email') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control form-control-sm">
                                <option value="">All Roles</option>
                                <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin (Raqi)</option>
                                <option value="patient" {{ request('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <select name="specialization" id="specialization" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="ruqyah_healing" {{ request('specialization') == 'ruqyah_healing' ? 'selected' : '' }}>Ruqyah Healing</option>
                                <option value="hijama_cupping" {{ request('specialization') == 'hijama_cupping' ? 'selected' : '' }}>Hijama Cupping</option>
                                <option value="both" {{ request('specialization') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-sm mr-2">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Specialization</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            <div class="avatar-title bg-primary rounded-circle">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
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
                                <td>
                                    @if($user->specialization)
                                        <span class="badge badge-light">{{ $user->specialization_label }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('superadmin.users.show', $user) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.users.edit', $user) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('superadmin.users.destroy', $user) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $users->where('role', 'super_admin')->count() }}</h3>
                    <p>Super Admins</p>
                </div>
                <div class="icon">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $users->where('role', 'admin')->count() }}</h3>
                    <p>Admins (Raqis)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $users->where('role', 'patient')->count() }}</h3>
                    <p>Patients</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $users->count() }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle search form visibility
        const toggleButton = document.getElementById('toggleSearchForm');
        const searchContainer = document.getElementById('searchFormContainer');
        
        // Check if search parameters exist in URL and show form if they do
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.toString()) {
            searchContainer.style.display = 'block';
            toggleButton.innerHTML = '<i class="fas fa-times"></i> Hide Search Options';
        }
        
        toggleButton.addEventListener('click', function() {
            if (searchContainer.style.display === 'none') {
                searchContainer.style.display = 'block';
                toggleButton.innerHTML = '<i class="fas fa-times"></i> Hide Search Options';
            } else {
                searchContainer.style.display = 'none';
                toggleButton.innerHTML = '<i class="fas fa-search"></i> Show Search Options';
            }
        });
    });
</script>
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
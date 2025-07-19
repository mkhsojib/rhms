@extends('layouts.frontend')

@section('title', 'Patient Dashboard - Ruqyah & Hijama Center')

@section('navigation-links')
    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
    <a href="{{ route('patient.appointments.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">My Appointments</a>
@endsection

@section('mobile-navigation-links')
    <a href="{{ url('/') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Home</a>
    <a href="{{ route('patient.appointments.index') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">My Appointments</a>
@endsection

@section('content')
    <div class="min-h-screen pt-20 pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user-circle text-indigo-600 text-4xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">
                    Welcome back, {{ Auth::user()->name }}!
                </h1>
                <p class="text-white text-opacity-90 text-lg">
                    Manage your appointments and track your healing journey
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Appointments</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Approved</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-check-double text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_appointments'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Upcoming Appointments -->
                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Upcoming Appointments</h2>
                        <a href="{{ route('patient.appointments.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Book New
                        </a>
                    </div>
                    
                    @if($upcoming_appointments->count() > 0)
                        <div class="space-y-4">
                            @foreach($upcoming_appointments as $appointment)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $appointment->practitioner->name }}</h3>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ date('M d, Y', strtotime($appointment->appointment_date)) }} at {{ $appointment->appointment_time }}
                                            </p>
                                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $appointment->type === 'ruqyah' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($appointment->type) }}
                                            </span>
                                        </div>
                                        <a href="{{ route('patient.appointments.show', $appointment) }}" 
                                           class="text-indigo-600 hover:text-indigo-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">No upcoming appointments</p>
                            <a href="{{ route('patient.appointments.create') }}" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                                Book Your First Appointment
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Recent Appointments -->
                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Appointments</h2>
                    
                    @if($recent_appointments->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_appointments as $appointment)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $appointment->practitioner->name }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ date('M d, Y', strtotime($appointment->appointment_date)) }}
                                            </p>
                                            <div class="flex items-center mt-2">
                                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $appointment->type === 'ruqyah' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ ucfirst($appointment->type) }}
                                                </span>
                                                <span class="ml-2 inline-block px-2 py-1 text-xs font-semibold rounded-full
                                                    @switch($appointment->status)
                                                        @case('pending')
                                                            bg-yellow-100 text-yellow-800
                                                            @break
                                                        @case('approved')
                                                            bg-green-100 text-green-800
                                                            @break
                                                        @case('completed')
                                                            bg-blue-100 text-blue-800
                                                            @break
                                                        @case('rejected')
                                                            bg-red-100 text-red-800
                                                            @break
                                                    @endswitch">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ route('patient.appointments.show', $appointment) }}" 
                                           class="text-indigo-600 hover:text-indigo-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">No recent appointments</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <div class="dashboard-card rounded-lg p-6 card-shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('patient.appointments.create') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Book Appointment</h3>
                                <p class="text-sm text-gray-600">Schedule a new treatment</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('patient.appointments.index') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-calendar-alt text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">View All</h3>
                                <p class="text-sm text-gray-600">See all appointments</p>
                            </div>
                        </a>

                        <a href="{{ route('patient.profile.edit') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-user-edit text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Edit Profile</h3>
                                <p class="text-sm text-gray-600">Update your information</p>
                            </div>
                        </a>

                        <a href="{{ route('patient.profile.change-password') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                <i class="fas fa-lock text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Change Password</h3>
                                <p class="text-sm text-gray-600">Update your password</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Alpine.js for dropdown functionality -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection 
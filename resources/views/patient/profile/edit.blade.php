@extends('layouts.frontend')

@section('title', 'Edit Profile - Ruqyah & Hijama Center')

@section('navigation-links')
    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
    <a href="{{ route('patient.appointments.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">My Appointments</a>
@endsection

@section('mobile-navigation-links')
    <a href="{{ url('/') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Home</a>
    <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Dashboard</a>
    <a href="{{ route('patient.appointments.index') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">My Appointments</a>
@endsection

@section('content')
    <div class="min-h-screen pt-20 pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Edit Profile</h1>
                <p class="text-white text-opacity-90">Update your personal information</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="auth-card rounded-lg p-8 card-shadow">
                        @if(session('success'))
                            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('patient.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="Enter your full name" required>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="Enter your email address" required>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number
                                    </label>
                                    <input type="text" name="phone" id="phone" 
                                           value="{{ old('phone', $user->phone) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="Enter your phone number">
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Address
                                </label>
                                <textarea name="address" id="address" rows="3" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Enter your address">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="mt-6">
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bio/About Me
                                </label>
                                <textarea name="bio" id="bio" rows="4" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Tell us about yourself, your experience, or any additional information...">{{ old('bio', $user->bio) }}</textarea>
                            </div>

                            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-indigo-700 transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Profile
                                </button>
                                <a href="{{ route('home') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg font-medium hover:bg-gray-600 transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Profile Summary -->
                <div class="lg:col-span-1">
                    <div class="auth-card rounded-lg p-6 card-shadow">
                        <div class="text-center mb-6">
                            <div class="mx-auto h-20 w-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-user-circle text-indigo-600 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        </div>

                        <div class="space-y-4">
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-medium text-gray-800 mb-3">Profile Information</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Role:</span>
                                        <span class="font-medium text-gray-800">{{ ucfirst($user->role) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-medium text-gray-800">{{ $user->phone ?: 'Not provided' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Bio:</span>
                                        <span class="font-medium text-gray-800">{{ $user->bio ?: 'Not provided' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Member Since:</span>
                                        <span class="font-medium text-gray-800">{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-medium text-gray-800 mb-3">Quick Actions</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('patient.profile.change-password') }}" 
                                       class="block w-full text-center bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600 transition duration-200">
                                        <i class="fas fa-lock mr-2"></i>Change Password
                                    </a>
                                    <a href="{{ route('patient.appointments.create') }}" 
                                       class="block w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition duration-200">
                                        <i class="fas fa-plus mr-2"></i>Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const successMessage = document.querySelector('.bg-green-100');
            if (successMessage) {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 5000);
    </script>
@endsection 
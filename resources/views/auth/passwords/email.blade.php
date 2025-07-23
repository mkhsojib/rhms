@extends('layouts.frontend')

@section('title', 'Forgot Password - Ruqyah & Hijama Center')

@section('navigation-links')
    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
@endsection

@section('mobile-navigation-links')
    <a href="{{ url('/') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Home</a>
@endsection

@section('content')
    <div class="auth-container min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 mt-16">
        <div class="max-w-md w-full">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-moon text-indigo-600 text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Forgot Password
                </h2>
                <p class="text-white text-opacity-90">
                    Reset your password
                </p>
            </div>

            <!-- Auth Card -->
            <div class="auth-card rounded-lg shadow-xl p-8 card-shadow">
@if (session('status'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
    @csrf

    <div class="text-center mb-6">
        <div class="mx-auto h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-key text-indigo-600 text-xl"></i>
        </div>
        <p class="text-gray-600">
            Enter your email address and we'll send you a link to reset your password.
        </p>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-envelope mr-2 text-indigo-600"></i>Email Address
        </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Enter your email address">
    </div>

    <div>
        <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
            <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
        </button>
    </div>
</form>
            </div>

            <!-- Footer Links -->
            <div class="text-center mt-6">
                <div class="text-white">
                    <p class="text-sm">
                        Remember your password? 
                        <a href="{{ route('login') }}" class="font-semibold hover:text-indigo-200 transition duration-200">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
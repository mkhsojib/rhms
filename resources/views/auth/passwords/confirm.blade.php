@extends('layouts.frontend')

@section('title', 'Confirm Password - Ruqyah & Hijama Center')

@section('navigation-links')
@endsection

@section('mobile-navigation-links')
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
                    Confirm Password
                </h2>
                <p class="text-white text-opacity-90">
                    Please confirm your password before continuing
                </p>
            </div>

            <!-- Auth Card -->
            <div class="auth-card rounded-lg shadow-xl p-8 card-shadow">
<form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
    @csrf

    <div class="text-center mb-6">
        <div class="mx-auto h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-shield-alt text-yellow-600 text-xl"></i>
        </div>
        <p class="text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock mr-2 text-indigo-600"></i>Password
        </label>
        <input id="password" type="password" name="password" required autocomplete="current-password"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Enter your password">
    </div>

    <div>
        <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
            <i class="fas fa-check mr-2"></i>Confirm Password
        </button>
    </div>
</form>
            </div>

            <!-- Footer Links -->
            <div class="text-center mt-6">
                <div class="text-white">
                    <p class="text-sm">
                        <a href="{{ route('home') }}" class="font-semibold hover:text-indigo-200 transition duration-200">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Dashboard
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
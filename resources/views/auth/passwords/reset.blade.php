@extends('layouts.frontend')

@section('title', 'Reset Password - Ruqyah & Hijama Center')

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
                    Reset Password
                </h2>
                <p class="text-white text-opacity-90">
                    Create a new password
                </p>
            </div>

            <!-- Auth Card -->
            <div class="auth-card rounded-lg shadow-xl p-8 card-shadow">
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
<form method="POST" action="{{ route('password.update') }}" class="space-y-6">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-envelope mr-2 text-indigo-600"></i>Email Address
        </label>
        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Enter your email address">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock mr-2 text-indigo-600"></i>New Password
        </label>
        <input id="password" type="password" name="password" required autocomplete="new-password"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Enter your new password">
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock mr-2 text-indigo-600"></i>Confirm New Password
        </label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Confirm your new password">
    </div>

    <div>
        <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
            <i class="fas fa-key mr-2"></i>Reset Password
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
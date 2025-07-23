@extends('layouts.frontend')

@section('title', 'Login - Ruqyah & Hijama Center')

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
                    Welcome Back
                </h2>
                <p class="text-white text-opacity-90">
                    Sign in to your account
                </p>
            </div>

            <!-- Auth Card -->
            <div class="auth-card rounded-lg shadow-xl p-8 card-shadow">
                @if(session('status'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-envelope mr-2 text-indigo-600"></i>Email Address
        </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Enter your email address"
               style="pointer-events: auto; position: relative; z-index: 50;">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock mr-2 text-indigo-600"></i>Password
        </label>
        <input id="password" type="password" name="password" required autocomplete="current-password"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
               placeholder="Enter your password"
               style="pointer-events: auto; position: relative; z-index: 50;">
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                   style="pointer-events: auto; position: relative; z-index: 50;">
            <label for="remember" class="ml-2 block text-sm text-gray-700">
                Remember me
            </label>
        </div>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 transition duration-200">
                Forgot your password?
            </a>
        @endif
    </div>

    <div>
        <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105"
                style="pointer-events: auto; position: relative; z-index: 50;">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
        </button>
    </div>
</form>

<script>
// Debug script to ensure form fields are interactive
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    if (emailInput) {
        emailInput.addEventListener('focus', function() {
            console.log('Email input focused');
        });
        emailInput.addEventListener('input', function() {
            console.log('Email input value:', this.value);
        });
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('focus', function() {
            console.log('Password input focused');
        });
        passwordInput.addEventListener('input', function() {
            console.log('Password input value:', this.value);
        });
    }
});
</script>
            </div>

            <!-- Footer Links -->
            <div class="text-center mt-6">
                <div class="text-white">
                    <p class="text-sm">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-semibold hover:text-indigo-200 transition duration-200">
                            Create one here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
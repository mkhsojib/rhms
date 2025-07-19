@extends('layouts.frontend')

@section('title', 'Verify Email - Ruqyah & Hijama Center')

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
                    Verify Email
                </h2>
                <p class="text-white text-opacity-90">
                    Please verify your email address
                </p>
            </div>

            <!-- Auth Card -->
            <div class="auth-card rounded-lg shadow-xl p-8 card-shadow">
<div class="text-center">
    <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
        <i class="fas fa-envelope-open text-blue-600 text-2xl"></i>
    </div>
    
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Email Verification Required</h3>
        <p class="text-gray-600">
            Before proceeding, please check your email for a verification link. If you did not receive the email, we will gladly send you another.
        </p>
    </div>

    @if (session('resent'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            A fresh verification link has been sent to your email address.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" 
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                <i class="fas fa-paper-plane mr-2"></i>Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </button>
        </form>
    </div>
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
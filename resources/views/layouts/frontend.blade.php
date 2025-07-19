<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruqyah & Hijama Healing Center')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .auth-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            position: relative;
            z-index: 10;
        }
        .dashboard-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            position: relative;
            z-index: 10;
        }
        .auth-container {
            position: relative;
            z-index: 20;
        }
        .background-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0.1;
            pointer-events: none;
        }
        /* Ensure form inputs are interactive */
        input, textarea, select {
            pointer-events: auto !important;
            position: relative;
            z-index: 30;
        }
    </style>
    @yield('styles')
</head>
<body class="gradient-bg min-h-screen">
    <!-- Background Pattern -->
    <div class="background-pattern" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <!-- Navigation -->
    <nav class="bg-white bg-opacity-90 backdrop-blur-sm shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-moon text-indigo-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">Ruqyah & Hijama Center</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    @yield('navigation-links')
                    
                    @guest
                        <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @else
                        <!-- Notification Bell -->
                        <div class="relative mr-4" x-data="{ open: false }">
                            <a href="{{ route('patient.notifications.index') }}" class="relative text-gray-700 hover:text-indigo-600 p-2" @click.prevent="open = !open">
                                <i class="fas fa-bell text-xl"></i>
                                <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">
                                    0
                                </span>
                            </a>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 max-h-96 overflow-y-auto">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <div id="notifications-list" class="divide-y divide-gray-200">
                                    <!-- Notifications will be loaded here -->
                                </div>
                                <div class="px-4 py-2 border-t border-gray-200">
                                    <a href="{{ route('patient.notifications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-700 hover:text-indigo-600 font-medium flex items-center">
                                <i class="fas fa-user-circle mr-2"></i>
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <a href="{{ route('patient.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-edit mr-2"></i>Edit Profile
                                </a>
                                <a href="{{ route('patient.profile.change-password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-lock mr-2"></i>Change Password
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-indigo-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @yield('mobile-navigation-links')
                
                @guest
                    <div class="border-t border-gray-200 mt-2 pt-2">
                        <a href="{{ route('login') }}" class="block px-3 py-2 bg-indigo-600 text-white rounded-lg mx-2 text-center font-medium hover:bg-indigo-700 transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    </div>
                @else
                    <div class="border-t border-gray-200 mt-2 pt-2">
                        <div class="px-3 py-2 text-gray-700">
                            <i class="fas fa-user-circle mr-2"></i>
                            {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('patient.profile.edit') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-edit mr-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('patient.profile.change-password') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-lock mr-2"></i>Change Password
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    @yield('scripts')
    
    <!-- Alpine.js for dropdown functionality -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Notification functionality
        @auth
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            loadUnreadCount();
            
            // Refresh notifications every 30 seconds
            setInterval(function() {
                loadNotifications();
                loadUnreadCount();
            }, 30000);
        });

        function loadNotifications() {
            fetch('{{ route("patient.notifications.recent") }}')
                .then(response => response.json())
                .then(notifications => {
                    const container = document.getElementById('notifications-list');
                    container.innerHTML = '';
                    
                    if (notifications.length === 0) {
                        container.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">No notifications</div>';
                        return;
                    }
                    
                    notifications.forEach(notification => {
                        const notificationHtml = `
                            <div class="px-4 py-3 hover:bg-gray-50 ${notification.read_at ? '' : 'bg-blue-50'}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="${getNotificationIcon(notification.type)} text-lg"></i>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900 ${notification.read_at ? '' : 'font-semibold'}">
                                            ${notification.title}
                                            ${!notification.read_at ? '<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-1">New</span>' : ''}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">${notification.message}</p>
                                        <p class="text-xs text-gray-500 mt-1">${formatTimeAgo(notification.created_at)}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += notificationHtml;
                    });
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        function loadUnreadCount() {
            fetch('{{ route("patient.notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    if (data.count > 0) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error loading unread count:', error);
                });
        }

        function getNotificationIcon(type) {
            switch (type) {
                case 'appointment_approved':
                    return 'fas fa-check-circle text-green-500';
                case 'appointment_rejected':
                    return 'fas fa-times-circle text-red-500';
                case 'appointment_cancelled':
                    return 'fas fa-ban text-gray-500';
                case 'appointment_completed':
                    return 'fas fa-check-double text-blue-500';
                case 'appointment_reminder':
                    return 'fas fa-bell text-yellow-500';
                default:
                    return 'fas fa-info-circle text-gray-500';
            }
        }

        function formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) {
                return 'Just now';
            } else if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
            } else if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                return `${hours} hour${hours > 1 ? 's' : ''} ago`;
            } else {
                const days = Math.floor(diffInSeconds / 86400);
                return `${days} day${days > 1 ? 's' : ''} ago`;
            }
        }
        @endauth
    </script>
    @stack('scripts')
</body>
</html> 
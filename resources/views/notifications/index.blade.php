@extends('layouts.frontend')

@section('title', 'Notifications - Ruqyah & Hijama Center')

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
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Notifications</h1>
                    <p class="text-white text-opacity-90 text-lg">Stay updated with your appointment status and important updates</p>
                </div>
                <div class="flex space-x-3">
                    <button id="mark-all-read" class="inline-flex items-center px-4 py-2 border border-white border-opacity-30 rounded-lg text-sm font-medium text-white bg-white bg-opacity-10 hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition duration-200">
                        <i class="fas fa-check-double mr-2"></i>
                        Mark All Read
                    </button>
                    <button id="delete-read-btn" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Read
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="dashboard-card rounded-lg card-shadow">
            @if($notifications->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        <li class="notification-item {{ $notification->isUnread() ? 'bg-blue-50' : 'bg-white' }}" data-id="{{ $notification->id }}">
                            <div class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="{{ $notification->icon }} text-2xl"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 {{ $notification->isUnread() ? 'font-semibold' : '' }}">
                                                        {{ $notification->title }}
                                                        @if($notification->isUnread())
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                                                New
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        {{ $notification->message }}
                                                    </p>
                                                    <div class="mt-2 flex items-center text-xs text-gray-500">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ $notification->time_ago }}
                                                        @if($notification->fromUser)
                                                            <span class="mx-2">•</span>
                                                            <i class="fas fa-user mr-1"></i>
                                                            {{ $notification->fromUser->name }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    @if($notification->appointment)
                                                        <a href="{{ route('patient.appointments.show', $notification->appointment) }}" 
                                                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                            View Appointment
                                                        </a>
                                                    @endif
                                                    <div class="flex items-center space-x-1">
                                                        <button class="mark-read-btn text-green-600 hover:text-green-900" title="Mark as read" {{ $notification->isUnread() ? '' : 'disabled style=\'opacity:0.4;cursor:not-allowed\'' }}>
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="mark-unread-btn text-gray-400 hover:text-gray-600" title="Mark as unread" {{ $notification->isRead() ? '' : 'disabled style=\'opacity:0.4;cursor:not-allowed\'' }}>
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                        <form action="{{ route('patient.notifications.destroy', $notification) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this notification?')" class="text-red-600 hover:text-red-900" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bell text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                    <p class="text-gray-500">You're all caught up! No new notifications at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Mark individual notification as read
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const notificationItem = this.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;
            
            console.log('Marking notification as read:', notificationId);
            
            const formData = new FormData();
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            formData.append('_token', csrfToken);
            
            const url = `/patient/notifications/${notificationId}/mark-read`;
            console.log('URL:', url);
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Update the UI
                    notificationItem.classList.remove('bg-blue-50');
                    notificationItem.classList.add('bg-white');
                    this.innerHTML = '<i class="fas fa-undo"></i>';
                    this.classList.remove('mark-read-btn', 'text-green-600', 'hover:text-green-900');
                    this.classList.add('mark-unread-btn', 'text-gray-400', 'hover:text-gray-600');
                    this.title = 'Mark as unread';
                    
                    // Remove "New" badge
                    const badge = notificationItem.querySelector('.inline-flex');
                    if (badge) {
                        badge.remove();
                    }
                    
                    // Update title font weight
                    const title = notificationItem.querySelector('.text-sm.font-medium');
                    title.classList.remove('font-semibold');
                    
                    console.log('UI updated successfully');
                } else {
                    console.error('Failed to mark as read:', data);
                }
            })
            .catch(error => {
                console.error('Error marking as read:', error);
            });
        });
    });

    // Mark individual notification as unread
    document.querySelectorAll('.mark-unread-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const notificationItem = this.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;
            
            console.log('Marking notification as unread:', notificationId);
            
            const formData = new FormData();
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            formData.append('_token', csrfToken);
            
            const url = `/patient/notifications/${notificationId}/mark-unread`;
            console.log('URL:', url);
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Update the UI
                    notificationItem.classList.remove('bg-white');
                    notificationItem.classList.add('bg-blue-50');
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    this.classList.remove('mark-unread-btn', 'text-gray-400', 'hover:text-gray-600');
                    this.classList.add('mark-read-btn', 'text-green-600', 'hover:text-green-900');
                    this.title = 'Mark as read';
                    
                    // Add "New" badge
                    const title = notificationItem.querySelector('.text-sm.font-medium');
                    const badge = document.createElement('span');
                    badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2';
                    badge.textContent = 'New';
                    title.appendChild(badge);
                    
                    // Update title font weight
                    title.classList.add('font-semibold');
                    
                    console.log('UI updated successfully');
                } else {
                    console.error('Failed to mark as unread:', data);
                }
            })
            .catch(error => {
                console.error('Error marking as unread:', error);
            });
        });
    });

    // Delete all read notifications
    document.getElementById('delete-read-btn').addEventListener('click', function() {
        if (!confirm('Are you sure you want to delete all read notifications?')) {
            return;
        }

        console.log('Deleting all read notifications');
        
        const formData = new FormData();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        formData.append('_token', csrfToken);
        
        const url = '{{ route("patient.notifications.delete-read") }}';
        console.log('URL:', url);
        
        fetch(url, {
            method: 'DELETE',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data && data.success) {
                console.log('Success! Deleted count:', data.deleted_count);
                window.location.reload();
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error deleting read notifications:', error);
            window.location.reload();
        });
    });

    document.getElementById('mark-all-read').addEventListener('click', function() {
        const formData = new FormData();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        formData.append('_token', csrfToken);
        fetch('{{ route("patient.notifications.mark-all-read") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });


});
</script>
@endpush
@endsection 
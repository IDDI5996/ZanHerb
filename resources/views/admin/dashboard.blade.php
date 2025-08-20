@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-7xl">
        <h1 class="text-3xl font-bold text-green-800 mb-8">Admin Dashboard</h1>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
            <!-- User Management -->
            <a href="{{ route('admin.users.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Manage Users</h2>
                <p class="text-gray-600 mt-2">View, add, edit, and disable users</p>
            </a>

            <!-- Manage Products -->
            <a href="{{ route('admin.products.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Manage Products</h2>
                <p class="text-gray-600 mt-2">Add, update, or delete remedies.</p>
            </a>

            <!-- Manage Services -->
            <a href="{{ route('admin.services.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Manage Services</h2>
                <p class="text-gray-600 mt-2">Edit service list & descriptions.</p>
            </a>

            <!-- Bookings -->
            <a href="{{ route('admin.bookings.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Bookings
                    @if($newBookingsCount > 0)
                        <span class="ml-2 px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $newBookingsCount }} new</span>
                    @endif
                </h2>
                <p class="text-gray-600 mt-2">View and manage appointments.</p>
            </a>

            <!-- Manage Promotions -->
            <a href="{{ route('admin.promotions.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Manage Promotions</h2>
                <p class="text-gray-600 mt-2">Post tips, videos, and updates.</p>
            </a>

            <!-- Manage Contacts -->
            <a href="{{ route('admin.contacts.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Manage Contacts
                    @if($unrespondedContactsCount > 0)
                        <span class="ml-2 px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $unrespondedContactsCount }} new</span>
                    @endif
                </h2>
                <p class="text-gray-600 mt-2">View and respond to contact messages.</p>
            </a>

            <!-- Manage Notifications -->
            <a href="{{ route('admin.notifications.index') }}" class="bg-green-50 p-6 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                <h2 class="text-xl font-semibold text-green-800">Manage Notifications</h2>
                <p class="text-gray-600 mt-2">Post announcements for all users.</p>
            </a>
        </div>

        <!-- Main Content Section -->
        <div class="space-y-8">
            <!-- First Row - Active Users and Recent Feedback -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Active Users -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-green-800">Active Users</h2>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                            {{ $activeUsersCount }} online
                        </span>
                    </div>
                    <div class="space-y-3">
                        @forelse($activeUsers as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-800 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-green-600">Active now</span>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">No active users</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Feedback -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-green-800">Recent Feedback</h2>
                        <a href="{{ route('admin.feedback.index') }}" class="text-green-600 hover:text-green-800 text-sm">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($feedbacks as $feedback)
                        <div class="border-l-4 border-green-600 pl-4 py-2 hover:bg-green-50 transition duration-150">
                            <p class="text-gray-700 italic">"{{ Str::limit($feedback->message, 80) }}"</p>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-gray-500">{{ $feedback->user->name ?? 'Guest' }}</span>
                                <span class="text-xs text-gray-400">{{ $feedback->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500">No recent feedback</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Second Row - Recent Bookings and Recent Contacts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-green-800">Recent Bookings</h2>
                        <a href="{{ route('admin.bookings.index') }}" class="text-green-600 hover:text-green-800 text-sm">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentBookings as $booking)
                        <div class="border-l-4 border-green-600 pl-4 py-2 hover:bg-green-50 transition duration-150">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $booking->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $booking->preferred_date->format('D, M j') }} at {{ $booking->preferred_time }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500">No recent bookings</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Contacts -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-green-800">Recent Contacts</h2>
                        <a href="{{ route('admin.contacts.index') }}" class="text-green-600 hover:text-green-800 text-sm">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentContacts as $contact)
                        <div class="border-l-4 @if($contact->responded) border-green-600 @else border-yellow-600 @endif pl-4 py-2 hover:bg-green-50 transition duration-150">
                            <p class="text-gray-700">{{ Str::limit($contact->message, 80) }}</p>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-gray-500">{{ $contact->name }}</span>
                                <span class="text-xs text-gray-400">{{ $contact->created_at->diffForHumans() }}</span>
                            </div>
                            @if($contact->responded)
                                <span class="inline-block mt-1 text-xs text-green-600">Responded</span>
                            @else
                                <span class="inline-block mt-1 text-xs text-yellow-600">Needs response</span>
                            @endif
                        </div>
                        @empty
                        <p class="text-gray-500">No recent contacts</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Notifications Section -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-green-800">Active Notifications</h2>
                <a href="{{ route('admin.notifications.index') }}" class="text-green-600 hover:text-green-800 text-sm">Manage All</a>
            </div>
            <div class="space-y-4">
                @forelse($activeNotifications as $notification)
                <div class="border-l-4 border-blue-600 pl-4 py-2 bg-blue-50">
                    <h3 class="font-medium text-gray-800">{{ $notification->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $notification->content }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs text-gray-500">Posted {{ $notification->created_at->diffForHumans() }}</span>
                        @if($notification->is_active)
                            <span class="text-xs text-green-600">Active</span>
                        @else
                            <span class="text-xs text-gray-500">Inactive</span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-gray-500">No active notifications</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
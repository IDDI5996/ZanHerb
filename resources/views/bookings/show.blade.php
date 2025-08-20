@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Booking Details
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ $booking->created_at->format('M j, Y \a\t g:i a') }}
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Full name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Email address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->email }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Phone number</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->phone }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Preferred Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->preferred_date->format('M j, Y') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Preferred Time</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->preferred_time }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Condition/Notes</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $booking->condition }}</dd>
                    </div>
                    @if($booking->status == 'cancelled' && $booking->cancellation_reason)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Cancellation Reason</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->cancellation_reason }}</dd>
                    </div>
                    @endif
                </div>
                
                <!--<div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end space-x-3">
                        @if($booking->status == 'pending')
                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Confirm Booking
                            </button>
                        </form>
                        @endif
                        
                        @if($booking->status != 'cancelled')
                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <div class="flex">
                                <input type="text" name="cancellation_reason" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Cancellation reason">
                                <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Cancel Booking
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>-->
            </div>
        </div>
        
        <div class="mt-5">
            <a href="{{ route('user.bookings.all') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Back to all bookings
            </a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<section class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-green-800">All My Bookings</h1>
                <a href="{{ route('dashboard') }}" class="text-sm text-green-600 hover:text-green-800">
                    ← Back to Dashboard
                </a>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('user.bookings.all') }}" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Filter
                        </button>
                        @if(request()->has('status') || request()->has('from_date') || request()->has('to_date'))
                            <a href="{{ route('user.bookings.all') }}" class="ml-2 text-sm text-gray-600 hover:text-gray-800">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Bookings List -->
            <div class="space-y-4">
                @if($bookings->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <p class="text-yellow-700">No bookings found matching your criteria.</p>
                    </div>
                @else
                    @foreach($bookings as $booking)
                        <div class="border rounded-lg overflow-hidden transition-all hover:shadow-md">
                            <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-3 md:mb-0">
                                    <div class="flex items-center mb-1">
                                        <h3 class="font-medium text-lg">{{ $booking->formatted_date }} at {{ $booking->formatted_time }}</h3>
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600"><span class="font-medium">Condition:</span> {{ $booking->condition }}</p>
                                    @if($booking->product)
                                        <p class="text-gray-600"><span class="font-medium">Product:</span> {{ $booking->product->name }}</p>
                                    @endif
                                    @if($booking->service)
                                        <p class="text-gray-600"><span class="font-medium">Service:</span> {{ $booking->service->name }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.shows', $booking->id) }}" class="text-sm text-blue-600 hover:text-blue-800">View</a>
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Cancel</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('bookings.archive', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">
                                            {{ $booking->is_archived ? 'Unarchive' : 'Archive' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
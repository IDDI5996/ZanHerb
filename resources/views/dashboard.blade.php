@extends('layouts.app')

@section('content')
<section class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Main Content -->
            <div class="md:w-2/3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-green-800 mb-2">Welcome to Your Dashboard</h1>
                        <p class="text-gray-600 mb-6">Here you can manage your bookings, view services, and provide feedback.</p>
                        
                        <!-- User Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-green-100 p-4 rounded-lg border border-green-200">
                                <h3 class="font-semibold text-green-800">Total Bookings</h3>
                                <p class="text-2xl font-bold">{{ $bookings->count() }}</p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-lg border border-blue-200">
                                <h3 class="font-semibold text-blue-800">Confirmed</h3>
                                <p class="text-2xl font-bold">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg border border-yellow-200">
                                <h3 class="font-semibold text-yellow-800">Pending</h3>
                                <p class="text-2xl font-bold">{{ $bookings->where('status', 'pending')->count() }}</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg border border-red-200">
                                <h3 class="font-semibold text-red-800">Cancelled</h3>
                                <p class="text-2xl font-bold">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                            </div>
                        </div>

                        <!-- Bookings Section -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold text-green-700">My Consultation Bookings</h2>
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                                        + New Booking
                                    </a>
                                    @if($bookings->count() > 3)
                                        <a href="{{ route('user.bookings.all') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                            View All
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($bookings->isEmpty())
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                    <p class="text-yellow-700">You don't have any bookings yet.</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($bookings->take(3) as $booking)
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
                                                    @if($booking->status !== 'pending')
                                                        <form action="{{ route('bookings.archive', $booking->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">Archive</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="md:w-1/3 space-y-6">
                <!-- Feedback Form -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Submit Feedback</h2>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('feedback.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Your Feedback</label>
                                <textarea name="message" rows="4" required 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                                Send Feedback
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Our Services</h2>
                        <div class="space-y-4">
                            @foreach($services->take(3) as $service)
                                <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex-shrink-0">
                                        @if($service->image_path)
                                            <img src="{{ asset($service->image_path) }}" alt="{{ $service->name }}" class="h-16 w-16 object-cover rounded-md">
                                        @else
                                            <div class="h-16 w-16 bg-green-100 rounded-md flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-green-800">{{ $service->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $service->duration }} mins • ${{ number_format($service->price, 2) }}</p>
                                        <a href="{{ route('services.show', $service->id) }}" class="text-xs text-blue-600 hover:text-blue-800">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pt-2">
                                <a href="{{ route('services.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">View all services →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Featured Products</h2>
                        <div class="space-y-4">
                            @foreach($products as $product)
                                <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-md">
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-green-800">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-600">${{ $product->price }}</p>
                                        <a href="{{ route('products.show', $product->id) }}" class="text-xs text-blue-600 hover:text-blue-800">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pt-2">
                                <a href="{{ route('products.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">View all products →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promotions Section -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Current Promotions</h2>
                        <div class="space-y-4">
                            @foreach($promotions as $promotion)
                                <div class="border rounded-lg overflow-hidden">
                                    @if(str_contains($promotion->image_path, '.mp4'))
                                        <video class="w-full h-auto" controls>
                                            <source src="{{ asset($promotion->image_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ asset($promotion->image_path) }}" alt="{{ $promotion->title }}" class="w-full h-auto">
                                    @endif
                                    <div class="p-3 bg-gray-50">
                                        <h3 class="font-medium text-green-800">{{ $promotion->title }}</h3>
                                        <p class="text-xs text-gray-500">Valid until {{ $promotion->end_date->format('M d, Y') }}</p>
                                        <a href="{{ $promotion->link }}" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">Learn more</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pt-2">
                                <a href="{{ route('promotions.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">View all promotions →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
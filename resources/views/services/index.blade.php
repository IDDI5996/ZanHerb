@extends('layouts.app')

@section('content')
<section class="py-16 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Our Services</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive healthcare solutions that blend traditional wisdom with modern science for your holistic well-being.</p>
        </div>

        <!-- Featured Services -->
        @if($featuredServices->count() > 0)
        <div class="mb-16">
            <h2 class="text-2xl font-semibold text-green-700 mb-8 text-center">Featured Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredServices as $service)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <span class="text-2xl text-green-600">
                                @include('partials.service-icon', [
                                    'icon' => $service->icon,
                                    'secondary_icon' => $service->secondary_icon
                                ])
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-green-800 mb-2 text-center">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4 text-center">{{ $service->description }}</p>
                        <div class="text-center">
                            <a href="{{ route('services.show', $service) }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Services by Category -->
        @foreach($categories as $category)
            @if(isset($servicesByCategory[$category]) && $servicesByCategory[$category]->count() > 0)
            <div class="mb-16">
                <h2 class="text-2xl font-semibold text-green-700 mb-8 flex items-center">
                    <span class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        @include('partials.category-icon', ['category' => $category])
                    </span>
                    {{ $category }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($servicesByCategory[$category] as $service)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <span class="text-xl text-green-600">
                                        @include('partials.service-icon', [
                                            'icon' => $service->icon,
                                            'secondary_icon' => $service->secondary_icon
                                        ])
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-green-800">{{ $service->name }}</h3>
                                    <p class="text-green-600 font-medium">{{ number_format($service->price, 2) }} TZS</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ $service->duration }} mins</span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('services.show', $service) }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                                        Details
                                    </a>
                                    <a href="{{ route('bookings.create') }}?service_id={{ $service->id }}" class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    </div>
</section>
@endsection
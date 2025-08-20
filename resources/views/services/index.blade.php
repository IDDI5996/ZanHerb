@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <h1 class="text-3xl font-bold text-green-800 mb-8">Our Services</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-green-700 mb-2">{{ $service->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-medium">{{ $service->duration }} mins • ${{ number_format($service->price, 2) }}</span>
                            <a href="{{ route('bookings.create') }}" class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
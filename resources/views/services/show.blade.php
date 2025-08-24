@extends('layouts.app')

@section('content')
<section class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Service Details -->
            <div class="md:w-2/3">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <!-- Breadcrumb Navigation -->
                        <nav class="flex mb-6" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('services.index') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        All Services
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <a href="{{ route('services.index') }}#{{ Str::slug($service->category) }}" class="ml-1 text-sm font-medium text-green-600 hover:text-green-800 md:ml-2">
                                            {{ $service->category }}
                                        </a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $service->name }}</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                        <div class="flex items-start mb-6">
                            <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mr-5">
                                <span class="text-2xl text-green-600">
                                    @include('partials.service-icon', [
                                        'icon' => $service->icon,
                                        'secondary_icon' => $service->secondary_icon
                                    ])
                                </span>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-green-800 mb-2">{{ $service->name }}</h1>
                                <div class="flex items-center">
                                    <span class="text-xl font-semibold text-green-600">{{ number_format($service->price, 2) }} TZS</span>
                                    <span class="ml-4 px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                        {{ $service->duration }} minutes
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="prose max-w-none mb-8 text-gray-700">
                            @if($service->long_description)
                                {!! nl2br(e($service->long_description)) !!}
                            @else
                                {!! nl2br(e($service->description)) !!}
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h2 class="text-lg font-semibold text-green-700 mb-4">What to Expect</h2>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Professional consultation with certified practitioners</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Personalized treatment plan tailored to your needs</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Follow-up care instructions and support</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Natural and evidence-based approaches</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Related Services -->
                @if($relatedServices->count() > 0)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-green-700 mb-4">Related Services</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($relatedServices as $relatedService)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 p-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-green-600">
                                        @include('partials.service-icon', [
                                            'icon' => $relatedService->icon,
                                            'secondary_icon' => $relatedService->secondary_icon
                                        ])
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-green-800">{{ $relatedService->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ number_format($relatedService->price, 2) }} TZS • {{ $relatedService->duration }} mins</p>
                                </div>
                                <a href="{{ route('services.show', $relatedService) }}" class="ml-auto text-sm text-green-600 hover:text-green-800 font-medium">
                                    View →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Booking Sidebar -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Book This Service</h2>
                        
                        <div class="mb-4 p-4 bg-green-50 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium">Service Fee:</span>
                                <span class="font-bold text-green-700">{{ number_format($service->price, 2) }} TZS</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium">Duration:</span>
                                <span>{{ $service->duration }} minutes</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Category:</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $service->category }}</span>
                            </div>
                        </div>

                        <a href="{{ route('bookings.create') }}?service_id={{ $service->id }}" 
                           class="w-full block text-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium shadow-md hover:shadow-lg">
                            Book Now
                        </a>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="font-medium text-gray-700 mb-2">Have questions?</h3>
                            <p class="text-sm text-gray-600 mb-4">Contact our support team for more information about this service.</p>
                            <a href="{{ route('contact.send') }}" class="text-sm text-green-600 hover:text-green-800 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
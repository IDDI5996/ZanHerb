@extends('layouts.app')

@section('content')
<section class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Details -->
            <div class="md:w-2/3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <!-- Breadcrumb Navigation -->
                        <nav class="flex mb-6" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        All Products
                                    </a>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name }}</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                        <div class="flex flex-col md:flex-row gap-6 mb-6">
                            <div class="md:w-1/3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="w-full h-auto rounded-lg shadow-sm border border-gray-200">
                            </div>
                            <div class="md:w-2/3">
                                <h1 class="text-2xl font-bold text-green-800 mb-2">{{ $product->name }}</h1>
                                
                                <div class="flex items-center mb-4">
                                    <span class="text-xl font-semibold text-green-600">{{ number_format($product->price) }} TZS</span>
                                    <span class="ml-3 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($product->tmda_status) }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <span class="text-sm text-gray-600">Package Size:</span>
                                    <span class="ml-2 text-sm font-medium">{{ $product->pack_size }}</span>
                                </div>

                                <a href="{{ route('bookings.create') }}?product_id={{ $product->id }}" 
                                   class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition mb-6">
                                    Book Consultation
                                </a>

                                <div class="border-t border-gray-200 pt-4">
                                    <h2 class="text-lg font-semibold text-green-700 mb-2">Key Benefits</h2>
                                    <div class="prose max-w-none">
                                        {!! nl2br(e($product->use)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6">
                            <h2 class="text-lg font-semibold text-green-700 mb-2">Ingredients</h2>
                            <div class="prose max-w-none">
                                {!! nl2br(e($product->ingredients)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Related Products</h2>
                        <div class="space-y-4">
                            @foreach($relatedProducts as $related)
                                <div class="flex items-center space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}" 
                                             class="h-16 w-16 object-cover rounded-md border border-gray-200">
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-green-800">{{ $related->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ number_format($related->price) }} TZS</p>
                                        <a href="{{ route('products.show', $related->id) }}" 
                                           class="text-xs text-blue-600 hover:text-blue-800">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
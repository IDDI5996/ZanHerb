@extends('layouts.app')

@section('content')
<section class="py-8 bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-green-800">Product Details</h1>
                <p class="text-gray-600 mt-2">View all details about this herbal product</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.products.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md flex items-center">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/3 bg-gray-50 p-6 flex items-center justify-center">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-64 w-full object-contain">
                </div>
                <div class="md:w-2/3 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
                            <div class="mt-1 flex items-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($product->tmda_status == 'approved') bg-green-100 text-green-800
                                    @elseif($product->tmda_status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($product->tmda_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-green-700">{{ number_format($product->price) }} TZS</div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Intended Use</h3>
                        <p class="mt-2 text-gray-600">{{ $product->use }}</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Ingredients</h3>
                        <p class="mt-2 text-gray-600">{{ $product->ingredients }}</p>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Pack Size</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $product->pack_size }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Created At</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Last Updated</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
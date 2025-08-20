@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-7xl">
        <h1 class="text-4xl font-bold text-green-800 text-center mb-10">Our Herbal Remedies</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="bg-green-50 p-4 rounded-lg shadow-md">
                    <img src="{{ asset('images/' . $product->image_path) }}"
                         alt="{{ $product->name }}" class="w-full h-48 object-cover rounded mb-4">

                    <h2 class="text-xl font-semibold text-green-800">{{ $product->name }}</h2>
                    <p class="text-gray-700 mb-2"><strong>Use:</strong> {{ $product->use }}</p>
                    <p class="text-gray-700 mb-2"><strong>Ingredients:</strong> {{ $product->ingredients }}</p>
                    <p class="text-gray-700 mb-2"><strong>Pack Size:</strong> {{ $product->pack_size }}</p>
                    <p class="text-gray-700 mb-2"><strong>TMDA:</strong> {{ $product->tmda_status }}</p>
                    <p class="text-green-700 font-bold text-lg mb-3">TZS {{ number_format($product->price) }}</p>

                    <a href="/contact" class="block text-center bg-green-700 text-white py-2 rounded hover:bg-green-800">
                        Request Purchase
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

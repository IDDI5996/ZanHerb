@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <h1 class="text-3xl font-bold text-green-800 mb-8">Our Products</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-green-700 mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 mb-1">{{ $product->pack_size }}</p>
                        <p class="text-green-600 font-bold mb-4">${{ number_format($product->price, 2) }}</p>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('products.show', $product->id) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                View Details
                            </a>
                            <a href="{{ route('bookings.create') }}?product_id={{ $product->id }}" class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                Book Consultation
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection
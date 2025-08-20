@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <h1 class="text-3xl font-bold text-green-800 mb-8">Current Promotions</h1>
        
        @if($promotions->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                <p class="text-yellow-700">There are no active promotions at this time.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($promotions as $promotion)
                    <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        @if(str_contains($promotion->image_path, '.mp4'))
                            <video class="w-full h-auto" controls>
                                <source src="{{ asset('storage/' . $promotion->image_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $promotion->image_path) }}" alt="{{ $promotion->title }}" class="w-full h-auto">
                        @endif
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-green-700 mb-2">{{ $promotion->title }}</h2>
                            <p class="text-gray-600 mb-4">{{ $promotion->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Valid until {{ $promotion->end_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
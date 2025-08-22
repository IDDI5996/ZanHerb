@extends('layouts.app')

@section('content')
<section class="bg-cover bg-center min-h-[80vh] flex items-center justify-center"
         style="background-image: url('/images/hero-banner.jpg');">
    <div class="bg-black bg-opacity-60 p-8 rounded-lg text-center text-white max-w-3xl">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">ZanHerb Integrative Centre</h1>
        <p class="text-xl mb-4 italic">"Rooted in Nature, Proven by Science"</p>
        <p class="text-lg mb-6">
            Welcome to ZanHerb — East Africa’s herbal-conventional medicine center led by Prof. Mayasa.
            Explore remedies rooted in tradition and backed by scientific innovation.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ auth()->check() && auth()->user()->is_admin ? route('admin.dashboard') : (auth()->check() ? route('dashboard') : url('/')) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded shadow-lg transition">
                    Book Consultation
            </a>

            <a href="/products"
               class="bg-white hover:bg-gray-200 text-green-800 px-5 py-3 rounded shadow-lg transition">
                Explore Products
            </a>
            <a href="{{ route('collaborate.create') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded shadow-lg transition">
                Join as Collaborator
            </a>
            <a href="/promotions"
               class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded shadow-lg transition">
                See Promotions
            </a>
        </div>
    </div>
</section>

<!-- Intro Section -->
<section class="py-12 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-semibold text-center text-green-800 mb-6">Who We Are</h2>
        <p class="max-w-4xl mx-auto text-lg text-gray-700 text-center">
            ZanHerb is an initiative of the Mayasa Foundation in Zanzibar. We specialize in integrative healthcare — combining herbal and conventional medical practices. Led by Prof. Mayasa, we provide consultations, custom remedies, laboratory testing, and community health education.
        </p>
    </div>
</section>

<!-- Promo Video (Optional) -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold text-green-800 mb-4">Explore Our Mission</h2>
        <div class="aspect-w-16 aspect-h-9 mx-auto max-w-4xl">
            <iframe class="w-full h-full rounded-lg shadow-lg"
                    src="https://www.youtube.com/embed/YOUR_VIDEO_ID_HERE"
                    title="ZanHerb Promo Video" allowfullscreen></iframe>
        </div>
    </div>
</section>
@endsection

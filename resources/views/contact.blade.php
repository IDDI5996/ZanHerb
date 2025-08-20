@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-6xl">
        <h1 class="text-4xl font-bold text-green-800 text-center mb-10">Contact Us</h1>

        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="space-y-4">
                <p class="text-gray-700"><strong>Phone:</strong> +255 712 345 678</p>
                <p class="text-gray-700"><strong>Email:</strong> info@zanherb.or.tz</p>
                <p class="text-gray-700"><strong>Address:</strong> Kijichi, Zanzibar, Tanzania</p>
                <a href="https://wa.me/255712345678" target="_blank"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    Chat on WhatsApp
                </a>
            </div>

            <!-- Google Map -->
            <div>
                <iframe
                    class="w-full h-64 rounded shadow"
                    src="https://www.google.com/maps/embed?pb=YOUR_GOOGLE_MAP_EMBED_CODE_HERE"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-green-50 p-8 rounded shadow">
            <h2 class="text-2xl font-semibold text-green-800 mb-6">Send Us a Message</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block font-medium text-gray-700">Your Name</label>
                    <input type="text" name="name" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Your Message</label>
                    <textarea name="message" rows="4" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm"></textarea>
                </div>

                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 shadow">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

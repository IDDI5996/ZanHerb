@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-6xl">
        <h1 class="text-4xl font-bold text-green-800 text-center mb-10">Contact Us</h1>

        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="space-y-4">
                <p class="text-gray-700"><strong>Phone:</strong> +255 714 424 747</p>
                <p class="text-gray-700"><strong>Email:</strong> info@zanherb.or.tz</p>
                <p class="text-gray-700">
                    <strong>Address:</strong> Zanzibar, Mjini Magharibi – Mchina Mwanzo, Tanzania
                </p>
                <a href="https://wa.me/255714424747" target="_blank"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    Chat on WhatsApp
                </a>

                <!-- Social Media Links -->
                <div class="mt-6 flex space-x-4">
                    <a href="https://t.me/YourTelegram" target="_blank" class="text-green-700 hover:text-green-900">
                        <i class="fab fa-telegram fa-2x"></i>
                    </a>
                    <a href="https://youtube.com/@bakarikitenja?si=CcYrklECSnF1_OpE" target="_blank" class="text-red-600 hover:text-red-800">
                        <i class="fab fa-youtube fa-2x"></i>
                    </a>
                    <a href="https://twitter.com/YourXProfile" target="_blank" class="text-blue-500 hover:text-blue-700">
                        <i class="fab fa-x-twitter fa-2x"></i>
                    </a>
                    <a href="https://whatsapp.com/channel/0029VbBuvoBL7UVOYRRFUW1I" target="_blank" class="text-green-500 hover:text-green-700">
                        <i class="fab fa-whatsapp fa-2x"></i>
                    </a>
                    <a href="https://instagram.com/YourInstagram" target="_blank" class="text-pink-500 hover:text-pink-700">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="https://facebook.com/YourFacebook" target="_blank" class="text-blue-700 hover:text-blue-900">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    <a href="https://tiktok.com/@YourTikTok" target="_blank" class="text-black hover:text-gray-700">
                        <i class="fab fa-tiktok fa-2x"></i>
                    </a>
                </div>
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
                    <input type="text" name="name" required 
                           class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Email or Phone Number</label>
                    <input type="text" name="contact" required 
                           placeholder="Enter your email or phone number"
                           class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Your Message</label>
                    <textarea name="message" rows="4" required 
                              class="w-full mt-1 border-gray-300 rounded-lg shadow-sm"></textarea>
                </div>

                <button type="submit" 
                        class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 shadow">
                    Send Message
                </button>
            </form>
        </div>

    </div>
</section>
@endsection

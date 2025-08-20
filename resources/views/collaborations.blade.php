@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-6xl">
        <h1 class="text-4xl font-bold text-green-800 text-center mb-10">Collaborate with Us</h1>

        <!-- Partner Logos/Profiles -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                <img src="/images/partners/zahri.png" alt="ZAHRI" class="w-28 h-28 mx-auto mb-4">
                <h2 class="text-xl font-semibold text-green-800">ZAHRI</h2>
                <p class="text-gray-600">Zanzibar Herbal Research Institute</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                <img src="/images/partners/suza.png" alt="SUZA" class="w-28 h-28 mx-auto mb-4">
                <h2 class="text-xl font-semibold text-green-800">SUZA</h2>
                <p class="text-gray-600">State University of Zanzibar</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                <img src="/images/partners/ngo.png" alt="NGO" class="w-28 h-28 mx-auto mb-4">
                <h2 class="text-xl font-semibold text-green-800">Herbal NGO</h2>
                <p class="text-gray-600">International Herbal Alliance</p>
            </div>
        </div>

        <!-- Collaboration Form -->
        <div class="bg-green-50 p-8 rounded shadow">
            <h2 class="text-2xl font-semibold text-green-800 mb-6">Request Partnership / MoU</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('collaborate.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block font-medium text-gray-700">Organization / Institution</label>
                    <input type="text" name="organization" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Your Name</label>
                    <input type="text" name="contact_name" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Purpose of Collaboration</label>
                    <textarea name="message" rows="4" required class="w-full mt-1 border-gray-300 rounded-lg shadow-sm"></textarea>
                </div>

                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 shadow">
                    Submit Request
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

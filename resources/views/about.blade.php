@extends('layouts.app')

@section('content')
<section class="bg-white py-12">
    <div class="container mx-auto px-6 max-w-5xl">
        <h1 class="text-4xl font-bold text-green-800 mb-6 text-center">About ZanHerb</h1>

        <!-- History and Mission -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Our Foundation</h2>
            <p class="text-gray-700 leading-relaxed">
                The Mayasa Foundation was established with the goal of integrating traditional African herbal medicine with modern science. Through ZanHerb, the foundation has pioneered accessible, culturally relevant, and scientifically validated herbal treatments in Zanzibar and beyond.
            </p>
        </div>

        <!-- Vision -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Our Vision</h2>
            <p class="text-gray-700 leading-relaxed">
                To be a center of excellence in integrative health by advancing the research, education, and application of traditional herbal remedies in harmony with conventional medicine.
            </p>
        </div>

        <!-- Team -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Prof. Mayasa -->
                <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                    <img src="{{ asset('storage/images/team/prof-mayasa.jpg') }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4" alt="Prof. Mayasa">
                    <h3 class="text-xl font-bold text-green-800">Prof. Mayasa</h3>
                    <p class="text-gray-600">Founder & Lead Integrative Health Specialist</p>
                </div>

                <!-- Biotechnologist -->
                <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                    <img src="/images/team/biotechnologist.jpg" class="w-32 h-32 object-cover rounded-full mx-auto mb-4" alt="Biotechnologist">
                    <h3 class="text-xl font-bold text-green-800">Dr. Asha Said</h3>
                    <p class="text-gray-600">Senior Biotechnologist</p>
                </div>

                <!-- Pharmacist -->
                <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                    <img src="{{ asset('storage/images/team/pharmacist.jpg') }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4" alt="Pharmacist">
                    <h3 class="text-xl font-bold text-green-800">Our Team</h3>
                    <p class="text-gray-600">Clinical Pharmacists</p>
                </div>
            </div>
        </div>

        <!-- Impact Stats -->
        <div class="bg-green-50 py-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center text-green-800 mb-6">Our Impact</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 text-center gap-6 px-4">
                <div>
                    <p class="text-4xl font-bold text-green-700">2,500+</p>
                    <p class="text-gray-700">Patients Treated</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-green-700">120+</p>
                    <p class="text-gray-700">Custom Herbal Remedies</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-green-700">15+</p>
                    <p class="text-gray-700">Research Collaborations</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

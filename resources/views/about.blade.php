@extends('layouts.app')

@section('content')
<section class="bg-white py-12">
    <div class="container mx-auto px-6 max-w-5xl">
        <h1 class="text-4xl font-bold text-green-800 mb-6 text-center">About ZanHerb</h1>

        <!-- Foundation -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">About Us</h2>
            <p class="text-gray-700 leading-relaxed">
                The Mayasa Foundation, through its flagship initiative the ZanHerb Integrative Centre for Pharmacognosy & Therapeutics, is dedicated to transforming healthcare in Zanzibar and beyond. ZanHerb bridges traditional herbal wisdom with modern scientific practices to deliver safe, effective, and culturally trusted solutions for skin, reproductive, eye health, and chronic diseases.
            </p>
            <p class="text-gray-700 leading-relaxed mt-4">
                Our work extends beyond treatment. We actively empower local communities, particularly women farmers, by sourcing raw medicinal plants such as lemongrass (mchaichai) and other herbs directly from them, creating sustainable livelihoods while ensuring a reliable supply of high-quality raw materials for our small-scale processing unit. This approach strengthens both economic resilience and the authenticity of our herbal products.
            </p>
            <p class="text-gray-700 leading-relaxed mt-4">
                Led by Prof. Mayasa, a pioneer in integrative medicine, ZanHerb comprises a multidisciplinary team of scientists, healthcare professionals, and community partners. Together, we aim to improve public health outcomes, promote research-driven herbal innovation, and position Zanzibar as a regional leader in natural medicine.
            </p>
        </div>

        <!-- Vision -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Our Vision</h2>
            <p class="text-gray-700 leading-relaxed">
                To become the leading hub for sustainable, innovative herbal medicine in Zanzibar, Tanzania and whole East Africa, advancing community wellness and serving as a global model for harmonizing traditional and modern healthcare practices.
            </p>
        </div>

        <!-- Mission -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Our Mission</h2>
            <p class="text-gray-700 leading-relaxed">
                To provide integrative, science-backed herbal healthcare that empowers communities, uplifts women farmers in Zanzibar, improves public health, and preserves traditional knowledge for future generations.
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

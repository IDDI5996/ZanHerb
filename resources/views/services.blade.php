@extends('layouts.app')

@section('content')
<section class="bg-white py-12">
    <div class="container mx-auto px-6 max-w-6xl">
        <h1 class="text-4xl font-bold text-green-800 mb-10 text-center">Our Services</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Herbal-Conventional Consultations -->
            <div class="bg-green-50 p-6 rounded-lg shadow">
                <h2 class="text-2xl font-semibold text-green-800 mb-2">Herbal-Conventional Consultations</h2>
                <p class="text-gray-700 mb-4">
                    Personalized diagnosis and treatment combining traditional herbal remedies and modern science. Led by Prof. Mayasa and team.
                </p>
                <a href="/book" class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Book Now
                </a>
            </div>

            <!-- Custom Compounding -->
            <div class="bg-green-50 p-6 rounded-lg shadow">
                <h2 class="text-2xl font-semibold text-green-800 mb-2">Custom Compounding</h2>
                <p class="text-gray-700 mb-4">
                    Tailored herbal products for skin, eye, reproductive health and more. Carefully formulated per individual needs.
                </p>
                <a href="/book" class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Request Compounding
                </a>
            </div>

            <!-- Laboratory Testing -->
            <div class="bg-green-50 p-6 rounded-lg shadow">
                <h2 class="text-2xl font-semibold text-green-800 mb-2">Laboratory Testing</h2>
                <p class="text-gray-700 mb-4">
                    Comprehensive testing services for microbial, phytochemical, and pH analysis. Ensures safety and efficacy of products.
                </p>
                <a href="/book" class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Schedule Test
                </a>
            </div>

            <!-- Health Education Workshops -->
            <div class="bg-green-50 p-6 rounded-lg shadow">
                <h2 class="text-2xl font-semibold text-green-800 mb-2">Health Education Workshops</h2>
                <p class="text-gray-700 mb-4">
                    Community outreach and educational events to promote holistic health using local herbal knowledge and research.
                </p>
                <a href="/contact" class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Inquire Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-6xl">
        <h1 class="text-4xl font-bold text-green-800 text-center mb-10">Promotions & Videos</h1>

        <!-- Videos Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="aspect-w-16 aspect-h-9">
                <iframe class="w-full h-full rounded-lg shadow"
                    src="https://www.youtube.com/embed/YOUR_VIDEO_ID"
                    title="Product Promo" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="aspect-w-16 aspect-h-9">
                <iframe class="w-full h-full rounded-lg shadow"
                    src="https://www.youtube.com/embed/YOUR_VIDEO_ID"
                    title="Patient Testimonial" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Testimonials -->
        <div class="bg-green-50 p-6 rounded shadow mb-12">
            <h2 class="text-2xl font-semibold text-green-800 mb-4">What Our Clients Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-700 italic">"The skin cream cleared my daughter’s eczema in just two weeks. We’re so thankful to ZanHerb!"</p>
                    <p class="text-right font-bold mt-2 text-green-800">— Mama Amina, Zanzibar</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-gray-700 italic">"As a diabetic, I’ve seen great improvement using their herbal supplements along with my regular meds."</p>
                    <p class="text-right font-bold mt-2 text-green-800">— Charles M., Dar es Salaam</p>
                </div>
            </div>
        </div>

        <!-- Health Tips Section -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-semibold text-green-800 mb-4">Health Tips</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Drink herbal teas like ginger, lemongrass, and turmeric daily for immunity support.</li>
                <li>Avoid mixing herbal medicine with antibiotics without consulting a qualified herbalist.</li>
                <li>Sun-dry herbs properly to retain potency before grinding or preparing tonics.</li>
            </ul>
        </div>
    </div>
</section>
@endsection

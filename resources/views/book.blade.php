@extends('layouts.app')

@section('content')
<section class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-green-800 mb-3">Book a Consultation</h1>
            <p class="text-gray-600 max-w-lg mx-auto">Schedule your appointment with our healthcare professionals</p>
        </div>

        <!-- Status Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any()))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-lg shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-medium">Please fix these errors:</h3>
                </div>
                <ul class="list-disc pl-8 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Booking Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('bookings.store') }}" method="POST" class="p-6 md:p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                placeholder="07XXXXXXXX" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="space-y-6">
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Product (Optional)</label>
                            <select id="product_id" name="product_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">General Consultation</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}
                                        data-price="{{ $product->price }}">
                                        {{ $product->name }} ({{ number_format($product->price) }} TZS)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                            <input type="date" id="preferred_date" name="preferred_date"
                                min="{{ date('Y-m-d') }}" value="{{ old('preferred_date') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <div>
                            <label for="preferred_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                            <select id="preferred_time" name="preferred_time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">Select time</option>
                                @php
                                    $start = 8; // 8 AM
                                    $end = 17; // 5 PM
                                    $interval = 30; // minutes
                                @endphp
                                @for($i = $start; $i <= $end; $i++)
                                    @for($j = 0; $j < 60; $j += $interval)
                                        @php
                                            $time = sprintf('%02d:%02d', $i, $j);
                                            $display = date('g:i A', strtotime($time));
                                        @endphp
                                        <option value="{{ $time }}" {{ old('preferred_time') == $time ? 'selected' : '' }}>
                                            {{ $display }}
                                        </option>
                                    @endfor
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition / Reason for Consultation</label>
                    <textarea id="condition" name="condition" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('condition') }}</textarea>
                </div>

                <!-- Estimated Cost -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-700">Estimated Cost:</span>
                        <span class="text-lg font-bold text-green-700" id="estimatedCost">0 TZS</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">* Final cost may vary based on consultation</p>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <button type="submit"
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md transition duration-300 font-medium flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirm Booking
                    </button>
                    
                    <a href="{{ route('products.index') }}" class="px-8 py-3 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition duration-300 font-medium text-center">
                        View Products
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format number with commas for TZS
        function formatTZS(amount) {
            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " TZS";
        }

        // Set default date to today
        const dateInput = document.getElementById('preferred_date');
        if (!dateInput.value) {
            dateInput.value = new Date().toISOString().split('T')[0];
        }

        // Calculate estimated cost
        const productSelect = document.getElementById('product_id');
        const estimatedCost = document.getElementById('estimatedCost');
        
        function updateCost() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = selectedOption.dataset.price || 0;
            estimatedCost.textContent = formatTZS(price);
        }

        productSelect.addEventListener('change', updateCost);
        updateCost(); // Initial calculation

        // Disable past times for today
        const timeSelect = document.getElementById('preferred_time');
        dateInput.addEventListener('change', function() {
            const today = new Date().toISOString().split('T')[0];
            const isToday = this.value === today;
            
            if (isToday) {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinute = now.getMinutes();
                
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value) {
                        const [hour, minute] = option.value.split(':').map(Number);
                        option.disabled = hour < currentHour || 
                                         (hour === currentHour && minute < currentMinute);
                    }
                });
            } else {
                Array.from(timeSelect.options).forEach(option => {
                    option.disabled = false;
                });
            }
        });
        
        // Trigger change event initially
        dateInput.dispatchEvent(new Event('change'));

        // Phone number formatting
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function(e) {
            // Remove any non-digit characters
            let value = this.value.replace(/\D/g, '');
            
            // Format as Tanzanian phone number (07XXXXXXXX)
            if (value.length > 2) {
                value = value.substring(0, 2) + value.substring(2);
            }
            
            // Limit to 9 digits after 0
            if (value.length > 9 && value.startsWith('0')) {
                value = value.substring(0, 10);
            }
            
            this.value = value;
        });
    });
</script>
@endsection
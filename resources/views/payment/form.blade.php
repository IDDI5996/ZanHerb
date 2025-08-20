@extends('layouts.app')

@section('content')
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 max-w-lg">
        <h1 class="text-3xl font-bold text-green-800 mb-6 text-center">Make a Mobile Payment</h1>

        @if(session('success'))
            <div class="bg-green-100 p-4 text-green-800 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pay.now') }}" method="POST" class="bg-green-50 p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-gray-700">Phone Number (e.g., 2557XXXXXXXX)</label>
                <input type="text" name="phone" required class="w-full mt-1 rounded border-gray-300">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Amount (TZS)</label>
                <input type="number" name="amount" min="500" required class="w-full mt-1 rounded border-gray-300">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Provider</label>
                <select name="provider" class="w-full mt-1 rounded border-gray-300">
                    <option value="mpesa">M-Pesa (Vodacom)</option>
                    <option value="tigopesa">Tigo Pesa</option>
                </select>
            </div>

            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                Pay Now
            </button>
        </form>
    </div>
</section>
@endsection

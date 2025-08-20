@extends('layouts.app')

@section('content')
<section class="py-8 bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-800">Edit Product</h1>
            <p class="text-gray-600 mt-2">Update product details</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Intended Use -->
                    <div>
                        <label for="use" class="block text-sm font-medium text-gray-700">Intended Use *</label>
                        <textarea name="use" id="use" rows="3" 
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>{{ old('use', $product->use) }}</textarea>
                        @error('use')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ingredients -->
                    <div>
                        <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingredients *</label>
                        <textarea name="ingredients" id="ingredients" rows="3" 
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>{{ old('ingredients', $product->ingredients) }}</textarea>
                        @error('ingredients')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Pack Size -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price (TZS) *</label>
                            <input type="number" name="price" id="price" min="0" step="0.01" 
                                   value="{{ old('price', $product->price) }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="pack_size" class="block text-sm font-medium text-gray-700">Pack Size *</label>
                            <input type="text" name="pack_size" id="pack_size" 
                                   value="{{ old('pack_size', $product->pack_size) }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                            @error('pack_size')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TMDA Status -->
                    <div>
                        <label for="tmda_status" class="block text-sm font-medium text-gray-700">TMDA Status *</label>
                        <select name="tmda_status" id="tmda_status" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                            @foreach(['approved', 'pending', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ old('tmda_status', $product->tmda_status) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                        @error('tmda_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Product Image</label>
                        <div class="mt-1 flex items-center">
                            <img id="imagePreview" src="{{ $product->image_url }}" class="h-20 w-20 rounded-md object-cover mr-4">
                            <div>
                                <input type="file" name="image" id="image" accept="image/*" 
                                       class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                       onchange="previewImage(this)">
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
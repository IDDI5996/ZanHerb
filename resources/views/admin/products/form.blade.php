@php
    $isEdit = isset($product);
    $action = $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store');
@endphp

@extends('layouts.app')

@section('content')
<section class="py-8 bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-800">{{ $isEdit ? 'Edit Product' : 'Add New Product' }}</h1>
            <p class="text-gray-600 mt-2">{{ $isEdit ? 'Update product details' : 'Fill in the form to add a new product' }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="grid grid-cols-1 gap-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                        <select name="category_id" id="category_id" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" id="price" step="0.01" min="0" 
                                       value="{{ old('price', $product->price ?? '') }}" 
                                       class="focus:ring-green-500 focus:border-green-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock Quantity *</label>
                            <input type="number" name="stock" id="stock" min="0" 
                                   value="{{ old('stock', $product->stock ?? '') }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Product Image</label>
                        <div class="mt-1 flex items-center">
                            @if($isEdit && $product->image_url)
                            <img id="imagePreview" src="{{ $product->image_url }}" class="h-20 w-20 rounded-md object-cover mr-4">
                            @else
                            <img id="imagePreview" src="{{ asset('images/default-product.png') }}" class="h-20 w-20 rounded-md object-cover mr-4">
                            @endif
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

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center">
                                <input id="active" name="is_active" type="radio" value="1" 
                                       {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} 
                                       class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                <label for="active" class="ml-2 block text-sm text-gray-700">Active</label>
                            </div>
                            <div class="flex items-center">
                                <input id="inactive" name="is_active" type="radio" value="0" 
                                       {{ old('is_active', $product->is_active ?? false) ? '' : 'checked' }} 
                                       class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                <label for="inactive" class="ml-2 block text-sm text-gray-700">Inactive</label>
                            </div>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ $isEdit ? 'Update Product' : 'Add Product' }}
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
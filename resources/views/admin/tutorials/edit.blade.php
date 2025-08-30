@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-green-800 mb-6">Edit Tutorial</h2>

    <form action="{{ route('admin.tutorials.update', $tutorial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Title</label>
            <input type="text" name="title" value="{{ old('title', $tutorial->title) }}" 
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="3" 
                      class="w-full border rounded-lg px-3 py-2">{{ old('description', $tutorial->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Current Video</label>
            @if($tutorial->video_path)
                <video controls class="w-full rounded-lg mb-2">
                    <source src="{{ asset('storage/' . $tutorial->video_path) }}" type="video/mp4">
                </video>
            @else
                <p class="text-gray-500">No video uploaded.</p>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Upload New Video (optional)</label>
            <input type="file" name="video" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.tutorials.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection

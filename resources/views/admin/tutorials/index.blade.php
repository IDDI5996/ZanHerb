@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<section class="py-12 bg-gray-50">
    <!-- Stats Section -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-green-100 text-green-600">
                <i class="fas fa-video text-lg"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ $tutorials->count() }}</h2>
                <p class="text-gray-600">Total Videos</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                <i class="fas fa-eye text-lg"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ $tutorials->sum('views') }}</h2>
                <p class="text-gray-600">Total Views</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $hoursContent ?? 0 }}
                </h2>
                <p class="text-gray-600">Hours Content</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                <i class="fas fa-users text-lg"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $globalCompletion ?? 0 }}%
                </h2>
                <p class="text-gray-600">Completion Rate</p>
            </div>
        </div>
    </div>
</div>

    <div class="container mx-auto px-6 max-w-7xl">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-800">Video Tutorials</h1>
            <p class="text-gray-600 mt-2">Upload, manage, and share tutorials with users & guests.</p>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Upload New Tutorial</h3>
            </div>
            <form action="{{ route('admin.tutorials.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Video Title</label>
                        <input type="text" name="title" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                            <option>Product Tutorials</option>
                            <option>Health Tips</option>
                            <option>Usage Guides</option>
                            <option>Wellness Advice</option>
                        </select>
                    </div>
                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                    <!-- File Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Video</label>
                        <input type="file" name="video" accept="video/*" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        <p class="text-sm text-gray-500 mt-1">Supports MP4, MOV, AVI files up to 2GB</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition">
                        <i class="fas fa-save mr-2"></i> Save and Publish
                    </button>
                </div>
            </form>
        </div>

        <!-- Video Library -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Video Library</h3>
                <form method="GET" action="{{ route('admin.tutorials.index') }}" class="flex space-x-4">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search videos..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        <option value="">All Categories</option>
                        <option>Product Tutorials</option>
                        <option>Health Tips</option>
                        <option>Usage Guides</option>
                        <option>Wellness Advice</option>
                    </select>
                </form>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tutorials as $tutorial)
                <div class="video-card bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <video id="tutorial-video-{{ $tutorial->id }}" class="tutorial-player w-full rounded-lg" playsinline controls>
                    <source src="{{ asset('storage/'.$tutorial->video_path) }}" type="video/mp4">
                </video>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const video = document.getElementById("tutorial-video-{{ $tutorial->id }}");
                            let counted = false;

                                if (video) {
                                    video.addEventListener("play", function () {
                                        if (!counted) {
                                            counted = true;
                                            fetch("{{ route('tutorials.incrementView', $tutorial->id) }}", {
                                                method: "POST",
                                                headers: {
                                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                                    "Content-Type": "application/json"
                                                },
                                                 body: JSON.stringify({})
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                console.log("View count updated:", data.views);

                                                // Find the counter span and update it
                                                //let counter = document.querySelector("#views-count-{{ $tutorial->id }}");
                                                //    if (counter) {
                                                //        counter.textContent = data.views + " views";
                                                //    }
                                            });
                                        }
                                    });
                                }
                         });
                    </script>
                    
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                            const player = new Plyr("#player-{{ $tutorial->id }}");

                            // Increment views only on first play
                            let viewCounted = false;
                        player.on("play", () => {
                            if (!viewCounted) {
                            viewCounted = true;
                            fetch("{{ route('tutorials.incrementView', $tutorial->id) }}", {
                                method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({})
                                }).then(r => r.json()).then(d => console.log("View +1:", d));
                            }
                        });

                        // Track progress continuously
                        player.on("timeupdate", () => {
                            let percent = Math.round((player.currentTime / player.duration) * 100);
                            if (percent > 0) {
                                fetch("{{ route('tutorials.updateProgress', $tutorial->id) }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({ progress: percent })
                                });
                            }
                        });

                        // On end, force 100%
                        player.on("ended", () => {
                            fetch("{{ route('tutorials.updateProgress', $tutorial->id) }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({ progress: 100 })
                            });
                        });
                    });
                    </script>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $tutorial->title }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ $tutorial->description }}</p>
                        
                        <div class="flex justify-between items-center text-xs text-gray-500 mt-2">
                            <span><i class="far fa-eye mr-1"></i> {{ $tutorial->formatted_views }} views</span>
                            <span><i class="far fa-clock mr-1"></i> {{ $tutorial->created_at->diffForHumans() }}</span>
                            <form action="{{ route('admin.tutorials.destroy', $tutorial->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tutorial?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.tutorials.edit', $tutorial->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                              Edit
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500">No tutorials uploaded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

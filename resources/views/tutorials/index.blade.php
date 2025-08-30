@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    
    <!-- Search + Filter -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <form method="GET" action="{{ route('tutorials.index') }}" class="flex w-full md:w-1/2">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Search tutorials..." 
                class="w-full px-4 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-green-500"
            >
            <button type="submit" 
                class="bg-green-600 text-white px-4 py-2 rounded-r-lg hover:bg-green-700">
                Search
            </button>
        </form>

        <form method="GET" action="{{ route('tutorials.index') }}">
            <select name="category" onchange="this.form.submit()" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500">
                <option value="">All Categories</option>
                <option value="Product Tutorials" {{ request('category')=='Product Tutorials' ? 'selected':'' }}>Product Tutorials</option>
                <option value="Health Tips" {{ request('category')=='Health Tips' ? 'selected':'' }}>Health Tips</option>
                <option value="Usage Guides" {{ request('category')=='Usage Guides' ? 'selected':'' }}>Usage Guides</option>
                <option value="Wellness Advice" {{ request('category')=='Wellness Advice' ? 'selected':'' }}>Wellness Advice</option>
            </select>
        </form>
    </div>

    <!-- Tutorials Grid -->
    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
        @forelse($tutorials as $tutorial)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-4 flex flex-col">
                <!-- Plyr Video Player -->
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
                <h3 class="mt-4 text-lg font-semibold text-gray-800">{{ $tutorial->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $tutorial->category }}</p>
                <p class="mt-2 text-gray-600 line-clamp-2">{{ $tutorial->description }}</p>
                
                <div class="text-xs text-gray-500 mt-1">
                    <span>
                        <i class="far fa-eye mr-1"></i>
                        <span id="views-count-{{ $tutorial->id }}">{{ $tutorial->formatted_views }}</span> views
                    </span>
                </div>
                
                <a href="{{ route('tutorials.show', $tutorial->id) }}" 
                   class="mt-3 text-green-600 hover:text-green-800 text-sm font-medium">
                   View Full
                </a>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">No tutorials found.</p>
        @endforelse
    </div>
</div>

<!-- Plyr.js -->
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Initialize all tutorial videos
    const players = Array.from(document.querySelectorAll('.tutorial-player')).map(video => new Plyr(video, {
        controls: [
            'play-large','play','progress','current-time','duration',
            'mute','volume','captions','settings','fullscreen'
        ],
        settings: ['speed','quality'],
        speed: { selected: 1, options: [0.5,1,1.25,1.5,2] }
    }));
});
</script>
@endsection

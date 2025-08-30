@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow rounded-2xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $tutorial->title }}</h1>
        <p class="text-gray-600 mb-6">{{ $tutorial->description }}</p>

        <!-- Plyr Video Player -->
        <video id="player" playsinline controls class="rounded-lg overflow-hidden w-full">
            <source src="{{ asset('storage/'.$tutorial->video_path) }}" type="video/mp4">
            @if($tutorial->captions)
                <track kind="captions" label="English" src="{{ asset('storage/'.$tutorial->captions) }}" srclang="en" default>
            @endif
        </video>
    </div>
</div>

<!-- Plyr.js -->
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const player = new Plyr('#player', {
            controls: [
                'play-large', 'play', 'progress', 'current-time', 'duration',
                'mute', 'volume', 'captions', 'settings', 'fullscreen'
            ],
            settings: ['speed', 'quality'],
            speed: { selected: 1, options: [0.5, 1, 1.25, 1.5, 2] }
        });
    });
</script>
@endsection

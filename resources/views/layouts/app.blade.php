<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            
            {{-- Navigation --}}
            @include('layouts.navigation')

            {{-- Notifications Banner --}}
            @isset($notifications)
                @if($notifications->count() > 0)
                    <div class="bg-blue-50 border-b border-blue-200">
                        <div class="container mx-auto px-4 py-2">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium text-blue-800">Announcements</span>
                                </div>
                            </div>
                            <div class="mt-2 space-y-2">
                                @foreach($notifications as $notification)
                                    <div class="text-sm text-blue-700">
                                        <strong>{{ $notification->title }}:</strong> {{ $notification->content }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endisset

            {{-- Page Heading (optional) --}}
            @hasSection('header')
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            {{-- Page Content --}}
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
<nav x-data="{ open: false }" class="bg-green-800 text-white shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() && auth()->user()->is_admin ? route('admin.dashboard') : (auth()->check() ? route('dashboard') : url('/')) }}">
                        <x-application-logo class="block h-11 w-11 object-cover rounded-full text-white" />
                    </a>
                </div>

                <!-- Dashboard Links (for authenticated users) -->
                @auth
                    @if(auth()->user()->is_admin)
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-gray-200">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                        </div>
                    @else
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-200">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Main Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                @if(!request()->routeIs('admin.dashboard'))
                    <!-- Show these links everywhere except admin dashboard -->
                    <x-nav-link href="/" :active="request()->is('/')" class="text-white hover:text-gray-200">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link href="/about" :active="request()->is('about')" class="text-white hover:text-gray-200">
                        {{ __('About') }}
                    </x-nav-link>
                    <x-nav-link href="/services" :active="request()->is('services')" class="text-white hover:text-gray-200">
                        {{ __('Services') }}
                    </x-nav-link>
                    <x-nav-link href="/products" :active="request()->is('products')" class="text-white hover:text-gray-200">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link href="/tutorials" :active="request()->is('tutorials')" class="text-white hover:text-gray-200">
                        {{ __('Tutorials') }}
                    </x-nav-link>
                    @auth
                        @if(!auth()->user()->is_admin)
                            <x-nav-link :href="route('bookings.create')" :active="request()->routeIs('bookings.create')" class="text-white hover:text-gray-200">
                                {{ __('Booking for Consultation') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('bookings.create')" :active="request()->routeIs('bookings.create')" class="text-white hover:text-gray-200">
                            {{ __('Booking for Consultation') }}
                        </x-nav-link>
                    @endauth
                    
                    <x-nav-link href="/contact" :active="request()->is('contact')" class="text-white hover:text-gray-200">
                        {{ __('Contact') }}
                    </x-nav-link>
                @endif
            </div>

            <!-- Auth Links (Login/Register or User Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ml-12">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-800 hover:bg-gray-100">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-gray-800 hover:bg-gray-100">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-white hover:text-gray-200">Login</a>
                        <a href="{{ route('register') }}" class="text-sm text-white hover:text-gray-200">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 hover:bg-green-700 focus:outline-none focus:bg-green-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-green-800">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:bg-green-700">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-green-700">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            @if(!request()->routeIs('admin.dashboard'))
                <x-responsive-nav-link href="/" :active="request()->is('/')" class="text-white hover:bg-green-700">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="/about" :active="request()->is('about')" class="text-white hover:bg-green-700">
                    {{ __('About') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="/services" :active="request()->is('services')" class="text-white hover:bg-green-700">
                    {{ __('Services') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="/products" :active="request()->is('products')" class="text-white hover:bg-green-700">
                    {{ __('Products') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="/tutorials" :active="request()->is('products')" class="text-white hover:bg-green-700">
                    {{ __('Tutorials') }}
                </x-responsive-nav-link>
                @auth
                    @if(!auth()->user()->is_admin)
                        <x-responsive-nav-link :href="route('bookings.create')" :active="request()->routeIs('bookings.create')" class="text-white hover:bg-green-700">
                            {{ __('Booking for Consultation') }}
                        </x-responsive-nav-link>
                    @endif
                @else
                    <x-responsive-nav-link :href="route('bookings.create')" :active="request()->routeIs('bookings.create')" class="text-white hover:bg-green-700">
                        {{ __('Booking for Consultation') }}
                    </x-responsive-nav-link>
                @endauth
                
                <x-responsive-nav-link href="/contact" :active="request()->is('contact')" class="text-white hover:bg-green-700">
                    {{ __('Contact') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-green-700">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-green-200">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-green-700">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="text-white hover:bg-green-700">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 space-y-1">
                    <a href="{{ route('login') }}" class="block py-2 text-sm text-white hover:bg-green-700">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 text-sm text-white hover:bg-green-700">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
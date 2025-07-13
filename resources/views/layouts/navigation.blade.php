<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Left: Logo & Links --}}
            <div class="flex items-center space-x-8">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ app(\App\Settings\WebsiteSettings::class)->favicon }}"
                        alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name }}"
                        class="h-8 w-8 rounded-full shadow object-cover">
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ config('app.name') }}
                    </span>
                </a>

                {{-- Desktop Links --}}
                <div class="hidden sm:flex space-x-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                        {{ __('Bookings') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Right: User & Notification --}}
            <div class="hidden sm:flex items-center space-x-4">
                {{-- Notifications --}}
                <x-dropdown align="left" width="64">
                    <x-slot name="trigger">
                        <button class="relative p-2 text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if (auth()->user()->unreadNotifications->count())
                                <span
                                    class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @forelse(auth()->user()->notifications->take(5) as $notification)
                            <div class="px-4 py-2 text-sm">
                                <p class="font-medium">{{ $notification->data['tour_title'] ?? '-' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ strtoupper($notification->data['status']) }} •
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        @empty
                            <div class="px-4 py-2 text-sm text-gray-500">No notifications</div>
                        @endforelse
                    </x-slot>
                </x-dropdown>

                {{-- User --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded text-sm text-gray-800 dark:text-gray-200">
                            <span>{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 20 20"
                                stroke="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger --}}
            <div class="sm:hidden">
                <button @click="open = !open" class="p-2 bg-white rounded hover:bg-white dark:hover:bg-gray-200">
                    {{-- Hamburger Icon --}}
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    {{-- Close Icon --}}
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2" class="sm:hidden">
        <div class="space-y-1 py-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                {{ __('Bookings') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t py-2">
            <div class="px-4 text-gray-800 dark:text-gray-300 font-medium">{{ Auth::user()->name }}</div>
            <div class="px-4 text-sm text-gray-500">{{ Auth::user()->email }}</div>
            <div class="mt-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

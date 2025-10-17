<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MarineBooking') }}</title>
        <link rel="icon" href="images/apple-touch-icon.ico">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> -->

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            @if(config('app.is_admin_area'))
                <div x-data="{ adminMenuOpen: false }" class="admin-nav bg-gray-800 text-white">
                    
                    <div class="container mx-auto hidden md:block">
                        <div class="flex gap-4 py-4">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Аналитика</a>
                            <a href="{{ route('admin.cruises.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/cruises*') ? 'bg-gray-700' : '' }}">Круизы</a>
                            <a href="{{ route('admin.voyages.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/voyages*') ? 'bg-gray-700' : '' }}">Рейсы</a>
                            <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/bookings*') ? 'bg-gray-700' : '' }}">Брони круизов</a>
                            <a href="{{ route('admin.voyage-bookings.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/voyage-bookings*') ? 'bg-gray-700' : '' }}">Брони рейсов</a>
                            <a href="{{ route('admin.vessels.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/vessels*') ? 'bg-gray-700' : '' }}">Судна</a>
                            <a href="{{ route('admin.ports.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/ports*') ? 'bg-gray-700' : '' }}">Порты</a>
                            <a href="{{ route('admin.users.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/users*') ? 'bg-gray-700' : '' }}">Пользователи</a>
                            <a href="{{ route('admin.reviews.pending') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/reviews*') ? 'bg-gray-700' : '' }}">Отзывы</a>
                             <a href="{{ route('admin.faq.index') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/faq*') ? 'bg-gray-700' : '' }}">FAQ</a>
                            <!-- <a href="{{ route('admin.analytics') }}" class="hover:text-gray-300 px-2 py-1 rounded {{ request()->is('admin/analytics*') ? 'bg-gray-700' : '' }}">Analytics</a> -->
                        </div>
                    </div>
                    
                    <div class="md:hidden">
                        <button @click="adminMenuOpen = !adminMenuOpen" class="w-full flex justify-between items-center px-4 py-3 bg-gray-700 hover:bg-gray-600">
                            <span>Меню админ. панели</span>
                            <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'transform rotate-180': adminMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="adminMenuOpen" x-transition class="bg-gray-800">
                            <div class="flex flex-col space-y-1 px-4 py-2">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Аналитика</a>
                                <a href="{{ route('admin.cruises.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/cruises*') ? 'bg-gray-700' : '' }}">Круизы</a>
                                <a href="{{ route('admin.voyages.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/voyages*') ? 'bg-gray-700' : '' }}">Рейсы</a>
                                <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/bookings*') ? 'bg-gray-700' : '' }}">Брони круизов</a>
                                <a href="{{ route('admin.voyage-bookings.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/voyage-bookings*') ? 'bg-gray-700' : '' }}">Брони рейсов</a>
                                <a href="{{ route('admin.vessels.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/vessels*') ? 'bg-gray-700' : '' }}">Судна</a>
                                <a href="{{ route('admin.ports.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/ports*') ? 'bg-gray-700' : '' }}">Порты</a>
                                <a href="{{ route('admin.users.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/users*') ? 'bg-gray-700' : '' }}">Пользователи</a>

                                <a href="{{ route('admin.reviews.pending') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/reviews*') ? 'bg-gray-700' : '' }}">Отзывы</a>

                                <a href="{{ route('admin.faq.index') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/faq*') ? 'bg-gray-700' : '' }}">FAQ</a>

                                <!-- <a href="{{ route('admin.analytics') }}" class="hover:text-gray-300 px-2 py-2 rounded {{ request()->is('admin/analytics*') ? 'bg-gray-700' : '' }}">Analytics</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <main>
                {{ $slot ?? '' }}
            </main>
        </div>
    </body>
</html>

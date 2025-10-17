<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Мои бронирования') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($upcomingBookings->isEmpty() && $completedBookings->isEmpty() && $otherBookings->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-500">Вы не совершали каких-либо бронирований. Но вы всегда можете сделать первый шаг!</p>
                    <a href="{{ route('cruises.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        К круизам
                    </a>
                    <a href="{{ route('voyages.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 ml-2">
                        К рейсам
                    </a>
                    <a href="{{ route('profile') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 ml-2">
                        Назад
                    </a>
                </div>
            @else
                <div class="space-y-8">
                    <div x-data="{ open: true }" class="bg-white rounded-xl shadow-md overflow-hidden mb-1">
                        <button 
                            @click="open = !open" 
                            class="w-full px-6 py-4 text-left focus:outline-none bg-blue-50"
                        >
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Предстоящие рейсы/круизы
                                    <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        {{ $upcomingBookings->count() }}
                                    </span>
                                </h3>
                                <svg 
                                    :class="{ 'transform rotate-180': open }" 
                                    class="w-5 h-5 text-blue-500 transition-transform duration-200" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        
                        <div x-show="open" x-collapse class="divide-y divide-gray-200">
                            @forelse($upcomingBookings as $booking)
                                @include('user.bookings.partials.booking-item', ['booking' => $booking])
                            @empty
                                <div class="px-6 py-4 text-gray-500">
                                    Нет бронирований в этой категории.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-md overflow-hidden mb-1">
                        <button 
                            @click="open = !open" 
                            class="w-full px-6 py-4 text-left focus:outline-none bg-green-50"
                        >
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Завершенные рейсы/круизы
                                    <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-gray-800 rounded-full">
                                        {{ $completedBookings->count() }}
                                    </span>
                                </h3>
                                <svg 
                                    :class="{ 'transform rotate-180': open }" 
                                    class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        
                        <div x-show="open" x-collapse class="divide-y divide-gray-200">
                            @forelse($completedBookings as $booking)
                                @include('user.bookings.partials.booking-item', ['booking' => $booking])
                            @empty
                                <div class="px-6 py-4 text-gray-500">
                                    Нет бронирований в этой категории.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-md overflow-hidden">
                        <button 
                            @click="open = !open" 
                            class="w-full px-6 py-4 text-left focus:outline-none bg-yellow-50"
                        >
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Отмененные/в обработке
                                    <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                        {{ $otherBookings->count() }}
                                    </span>
                                </h3>
                                <svg 
                                    :class="{ 'transform rotate-180': open }" 
                                    class="w-5 h-5 text-yellow-500 transition-transform duration-200" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        
                        <div x-show="open" x-collapse class="divide-y divide-gray-200">
                            @forelse($otherBookings as $booking)
                                @include('user.bookings.partials.booking-item', ['booking' => $booking])
                            @empty
                                <div class="px-6 py-4 text-gray-500">
                                    Нет бронирований в этой категории.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
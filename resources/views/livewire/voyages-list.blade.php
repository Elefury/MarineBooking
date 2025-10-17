<div>
    <div class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Вы можете найти здесь интересующий вас рейс
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Поиск
                </label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Название порта или номер рейса..."
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            
            
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Диапазон цен
                </label>
                <div class="flex space-x-2">
                    <input 
                        type="number" 
                        wire:model.live.debounce.500ms="minPrice" 
                        placeholder="Min"
                        class="w-1/2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                    <input 
                        type="number" 
                        wire:model.live.debounce.500ms="maxPrice" 
                        placeholder="Max"
                        class="w-1/2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Диапазон времени отправления
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <input 
                        type="date" 
                        wire:model.live="dateFrom"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                    <input 
                        type="date" 
                        wire:model.live="dateTo"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                </div>
            </div>
            
            <div class="flex items-end">
                <button 
                    wire:click="resetFilters"
                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Сбросить фильтры
                </button>
            </div>
        </div>
    </div>

    <div wire:loading.delay class="text-center py-12">
        <div class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-50 text-blue-700">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Загружаем...
        </div>
    </div>

    @if($voyages->count() > 0)
        <div class="mb-6 flex items-center space-x-4 gap-2 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <span class="text-sm text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                </svg>
                Сортировать по:
            </span>
            <button 
                wire:click="sortBy('departure_time')" 
                class="text-sm px-3 py-1 rounded-full {{ $sortField === 'departure_time' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }} flex items-center"
            >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Времени отправления
                @if($sortField === 'departure_time')
                    {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                @endif
            </button>
            <button 
                wire:click="sortBy('price_per_seat')" 
                class="text-sm px-3 py-1 rounded-full {{ $sortField === 'price_per_seat' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }} flex items-center"
            >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Цене
                @if($sortField === 'price_per_seat')
                    {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                @endif
            </button>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @foreach($voyages as $voyage)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-1">
                                    <a href="{{ route('voyages.show', $voyage) }}" class="hover:text-blue-600">
                                        {{ $voyage->voyage_number }}: 
                                        {{ $voyage->departurePort->name }} ({{ $voyage->departurePort->city }}, {{ $voyage->departurePort->country }}) 
                                        → 
                                        {{ $voyage->arrivalPort->name }} ({{ $voyage->arrivalPort->city }}, {{ $voyage->arrivalPort->country }})
                                    </a>
                                </h3>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21l18 0M5 21l2-16h10l2 16"></path>
                                    </svg>
                                    {{ $voyage->vessel->name }} ({{ $voyage->vessel->type }})
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($voyage->price_per_seat, 2) }}</span>
                                <span class="block text-sm text-gray-500">цена за место</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-sm text-gray-500 mb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Дата и время отправления:
                                </div>
                                <div class="font-medium text-gray-800">
                                    {{ $voyage->departure_time->format('d M Y, H:i') }}
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-sm text-gray-500 mb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Дата и время прибытия:
                                </div>
                                <div class="font-medium text-gray-800">
                                    {{ $voyage->arrival_time->format('d M Y, H:i') }}
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-sm text-gray-500 mb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Кол-во свободных мест:
                                </div>
                                <div class="font-medium text-gray-800">
                                    {{ $voyage->available_seats }} / {{ $voyage->passenger_capacity }}
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-sm text-gray-500 mb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    До закрытия бронирования:
                                </div>
                                @php
                                    $remaining = $this->formatRemainingTime($voyage->departure_time);
                                @endphp
                                <div class="font-medium {{ $remaining['color'] }}">
                                    {{ $remaining['text'] }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap justify-between gap-y-4">
                            <a 
                                href="{{ route('voyages.show', $voyage) }}" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-md transition-all duration-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Просмотреть
                            </a>
                            <a 
                                href="{{ route('voyage-booking.form', $voyage) }}" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-md transition-all duration-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Забронировать
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $voyages->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl shadow border border-gray-100">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">
                @if($search || $minPrice || $maxPrice || $dateFrom || $dateTo)
                    Нет рейсов в соответствии с вашими фильтрами.
                @else
                    На данный момент рейсов нет.
                @endif
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                @if($search || $minPrice || $maxPrice || $dateFrom || $dateTo)
                    Упростите запрос фильтрации.
                @else
                    Вернитесь позже за новыми предложениями.
                @endif
            </p>
            @if($search || $minPrice || $maxPrice || $dateFrom || $dateTo)
                <div class="mt-6">
                    <button 
                        wire:click="resetFilters"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Сбросить фильтры
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
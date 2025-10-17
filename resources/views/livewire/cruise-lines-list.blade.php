<div>
    <div class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Find Your Cruise
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Name or description..."
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"></path>
                </svg>
                Transport type
            </label>
            <select 
                wire:model.live="vesselType"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Any</option>
                @foreach($vesselTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Price
                </label>
                <div class="flex space-x-2">
                    <input 
                        type="number" 
                        wire:model.live="minPrice" 
                        placeholder="Min"
                        class="w-1/2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                    <input 
                        type="number" 
                        wire:model.live="maxPrice" 
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
                    Departure time
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
                    Reset filters
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
            Loading...
        </div>
    </div>

    @if($cruiseLines->count() > 0)
        <div class="mb-6 flex items-center space-x-4 gap-2 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <span class="text-sm text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                </svg>
                Sort by:
            </span>
            <button 
                wire:click="sortBy('departure_time')" 
                class="text-sm px-3 py-1 rounded-full {{ $sortField === 'departure_time' ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }} flex items-center"
            >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Departure
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
                Price
                @if($sortField === 'price_per_seat')
                    {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                @endif
            </button>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @foreach($cruiseLines as $cruise)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-gray-100">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 relative">
                            <div class="aspect-w-16 aspect-h-9 w-full h-full">
                                <img 
                                    src="{{ $cruise->image_url }}" 
                                    alt="{{ $cruise->name }}"
                                    class="w-full h-64 md:h-full object-cover"
                                    onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22600%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20600%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18945cb716a%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18945cb716a%22%3E%3Crect%20width%3D%22800%22%20height%3D%22600%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%3ECruise%20Image%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E'"
                                >
                            </div>
                            <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $cruise->available_seats }} seats available
                            </div>
                        </div>
                        
                        <div class="p-6 flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $cruise->name }}</h3>
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        {{ $cruise->destination }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-blue-600">${{ number_format($cruise->price_per_seat, 2) }}</span>
                                    <span class="block text-sm text-gray-500">price per seat</span>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mb-4">{{ Str::limit($cruise->description, 250) }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Departure:
                                    </div>
                                    <div class="font-medium text-gray-800">
                                        {{ $cruise->departure_time->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Transport
                                    </div>
                                    <div class="font-medium text-gray-800">
                                        @if($cruise->vessel)
                                            {{ $cruise->vessel->name }} ({{ $cruise->vessel->type }})
                                        @else
                                            Not specified
                                        @endif
                                    </div>
                                </div>
                                
                            <!-- <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Duration
                                    </div>
                                    <div class="font-medium text-gray-800">
                                        {{ $cruise->duration }} hours
                                    </div>
                                </div> -->
                                
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Booking expires in:
                                    </div>
                                    @php
                                        $remaining = $this->formatRemainingTime($cruise->departure_time);
                                    @endphp
                                    <div class="font-medium {{ $remaining['color'] }}">
                                        {{ $remaining['text'] }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap justify-between gap-y-4">
                                <a 
                                    href="{{ route('cruises.show', $cruise) }}" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-md transition-all duration-200"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    View
                                </a>

                                <a 
                                    href="{{ route('booking.form', $cruise) }}" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-md transition-all duration-200"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Book
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $cruiseLines->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl shadow border border-gray-100">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">
                @if($search || $minPrice || $maxPrice || $dateFrom || $dateTo)
                    По данным критерием круизов не найдено.
                @else
                    На текущий момент нет доступных круизов.
                @endif
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                @if($search || $minPrice || $maxPrice || $dateFrom || $dateTo)
                    Попробуйте изменить фильтры.
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



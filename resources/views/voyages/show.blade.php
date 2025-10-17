<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Рейс #{{ $voyage->voyage_number }}
                    </h1>
                    <p class="text-lg text-gray-600 mt-2">
                        {{ $voyage->departurePort->city }} → {{ $voyage->arrivalPort->city }}
                    </p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg w-full md:w-auto">
                    <div class="text-2xl font-bold text-blue-600">
                        ${{ number_format($voyage->price_per_seat, 2) }} 
                        <span class="text-sm font-normal text-gray-500">/ место</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ $voyage->available_seats }} из {{ $voyage->passenger_capacity }} мест свободно
                    </div>
                </div>
            </div>
            
            @if($voyage->vessel->image_url)
            <div class="rounded-xl overflow-hidden shadow-lg mb-6">
                <img src="{{ $voyage->vessel->image_url }}" alt="{{ $voyage->vessel->name }}" class="w-full h-96 object-cover">
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <line x1="12" y1="16" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <line x1="12" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Детали рейса
                </h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Отправление</p>
                            <p class="font-medium">
                                {{ $voyage->departure_time->format('d.m.Y H:i') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $voyage->departurePort->name }}<br>
                                {{ $voyage->departurePort->city }}, {{ $voyage->departurePort->country }}
                            </p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Прибытие</p>
                            <p class="font-medium">
                                {{ $voyage->arrival_time->format('d.m.Y H:i') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $voyage->arrivalPort->name }}<br>
                                {{ $voyage->arrivalPort->city }}, {{ $voyage->arrivalPort->country }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Продолжительность</p>
                        <p class="font-medium">
                            {{ $voyage->departure_time->diff($voyage->arrival_time)->format('%h ч %i мин') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21l18 0M5 21l2-16h10l2 16"></path>
                    </svg>
                    Информация о судне
                </h2>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium">Название:</span> 
                        <span>{{ $voyage->vessel->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Тип:</span> 
                        <span>{{ $voyage->vessel->type }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Вместимость:</span> 
                        <span>{{ $voyage->vessel->capacity }} пассажиров</span>
                    </div>
                    @if($voyage->vessel->description)
                    <div>
                        <span class="font-medium">Описание:</span> 
                        <p class="mt-1">{{ $voyage->vessel->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Порт отправления
                </h2>
                
                <div class="mt-2 h-64 bg-gray-100 rounded-lg overflow-hidden">
                    <iframe 
                        width="100%" 
                        height="100%"
                        frameborder="0" 
                        scrolling="no" 
                        marginheight="0" 
                        marginwidth="0" 
                        src="https://maps.google.com/maps?q={{ $voyage->departurePort->latitude }},{{ $voyage->departurePort->longitude }}&z=15&output=embed&language=ru">
                    </iframe>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Порт прибытия
                </h2>
                
                <div class="mt-2 h-64 bg-gray-100 rounded-lg overflow-hidden">
                    <iframe 
                        width="100%" 
                        height="100%"
                        frameborder="0" 
                        scrolling="no" 
                        marginheight="0" 
                        marginwidth="0" 
                        src="https://maps.google.com/maps?q={{ $voyage->arrivalPort->latitude }},{{ $voyage->arrivalPort->longitude }}&z=15&output=embed&language=ru">
                    </iframe>
                </div>
            </div>
        </div>

        
    <div class="sticky bottom-0  py-4  md:shadow-none md:bg-transparent md:py-0 md:mt-8">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-4 md:rounded-full md:border md:border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-center md:text-left">
                        <div class="text-sm text-gray-500">Цена от</div>
                        <div class="text-xl font-bold text-blue-600">
                            ${{ number_format($voyage->price_per_seat ?? $cruise->price_per_seat, 2) }}
                        </div>
                    </div>
                    <a href="{{ route('voyage-booking.form', $voyage)}}" 
                       class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold rounded-lg md:rounded-full shadow-lg transition-all transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Забронировать
                    </a>
                </div>
            </div>
        </div>
    </div>

    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $cruise->name }}</h1>
                    <p class="text-lg text-gray-600 mt-2">{{ $cruise->destination }}</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg w-full md:w-auto">
                    <div class="text-2xl font-bold text-blue-600">
                        ${{ number_format($cruise->price_per_seat, 2) }} 
                        <span class="text-sm font-normal text-gray-500">/ место</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ $cruise->available_seats }} мест доступно
                    </div>
                </div>
            </div>
            
            <div class="flex items-center text-gray-500 mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Отправление: {{ $cruise->departure_time->format('d.m.Y H:i') }}
            </div>
            
            @if($cruise->image_url)
            <div class="rounded-xl overflow-hidden shadow-lg mb-6">
                <img src="{{ $cruise->image_url }}" alt="{{ $cruise->name }}" class="w-full h-96 object-cover">
            </div>
            @endif
            
            <div class="prose max-w-none">
                <h3 class="text-xl font-semibold mb-3">Описание круиза</h3>
                <p>{{ $cruise->description }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            @if($cruise->vessel)
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <line x1="12" y1="16" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <line x1="12" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Информация о судне
                </h2>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium">Название:</span> 
                        <span>{{ $cruise->vessel->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Тип:</span> 
                        <span>{{ $cruise->vessel->type }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Вместимость:</span> 
                        <span>{{ $cruise->vessel->capacity }} пассажиров</span>
                    </div>
                    @if($cruise->vessel->description)
                    <div>
                        <span class="font-medium">Описание:</span> 
                        <p class="mt-1">{{ $cruise->vessel->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Место отправления
                </h2>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium">Место встречи:</span> 
                        <p>{{ $cruise->meeting_point }}</p>
                    </div>
                    
                    @if($cruise->meeting_latitude && $cruise->meeting_longitude)
                    <div>
                        <span class="font-medium">На карте:</span>
                        <div class="mt-2 h-64 bg-gray-100 rounded-lg overflow-hidden">
                            <iframe 
                                width="100%" 
                                height="100%"
                                frameborder="0" 
                                scrolling="no" 
                                marginheight="0" 
                                marginwidth="0" 
                                src="https://maps.google.com/maps?q={{ $cruise->meeting_latitude }},{{ $cruise->meeting_longitude }}&z=16&output=embed&language=ru">
                            </iframe>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        
        <div class="sticky bottom-0 py-4 md:shadow-none md:bg-transparent md:py-0 md:mt-8">
            <div class="container mx-auto px-4">
                <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-4 md:rounded-full md:border md:border-gray-200">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="text-center md:text-left">
                            <div class="text-sm text-gray-500">Цена от</div>
                            <div class="text-xl font-bold text-blue-600">
                                ${{ number_format($voyage->price_per_seat ?? $cruise->price_per_seat, 2) }}
                            </div>
                        </div>
                        <a href="{{ route('booking.form', $cruise) }}" 
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
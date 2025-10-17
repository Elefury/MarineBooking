<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <center><h1 class="text-3xl font-bold text-green-600 mb-4">Бронирование успешно!</h1></center>
                    
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold">
                            Рейс #{{ $booking->voyage->voyage_number }}
                        </h2>
                        <p class="text-gray-600">
                            {{ $booking->voyage->departurePort->name }} → 
                            {{ $booking->voyage->arrivalPort->name }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-gray-600">ID бронирования:</p>
                            <p class="font-bold">#{{ $booking->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Дата и время отправления</p>
                            <p class="font-medium">
                                {{ $booking->voyage->departure_time->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Мест забронировано</p>
                            <p class="font-medium">{{ $booking->seats }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Оплачено</p>
                            <p class="font-bold text-green-600">
                                ${{ number_format($booking->total_price, 2) }}
                            </p>
                        </div>
                    </div>


                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('voyages.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            К каталогу
                        </a>
                        @if($booking->ticket)
                            <a href="{{ route('tickets.show', $booking->ticket) }}" 
                               class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                                Просмотреть билет
                            </a>
                        @else
                            <span class="bg-gray-300 text-gray-600 px-6 py-2 rounded">
                                Техническая ошибка. Билет недоступен.
                            </span>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
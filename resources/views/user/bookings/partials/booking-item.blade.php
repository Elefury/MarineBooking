<div class="p-6 hover:bg-gray-50 transition-colors">
    <div class="flex flex-col md:flex-row justify-between">
        <div class="mb-4 md:mb-0">
            <h3 class="text-lg font-semibold">
                @if($booking instanceof \App\Models\Booking)
                    {{ $booking->cruiseLine->name }} (Круиз)
                @else
                    Рейс #{{ $booking->voyage->voyage_number }}
                @endif
            </h3>
            
            <div class="mt-2 text-sm text-gray-600">
                @if($booking instanceof \App\Models\Booking)
                    <p>Время отправления: {{ $booking->cruiseLine->departure_time->format('d M Y, H:i') }}</p>
                    <p>Место встречи: {{ $booking->cruiseLine->meeting_point }}</p>
                @else
                    <p>Маршрут: {{ $booking->voyage->departurePort->name }} → {{ $booking->voyage->arrivalPort->name }}</p>
                    <p>Время отправления: {{ $booking->voyage->departure_time->format('d M Y, H:i') }}</p>
                @endif
            </div>
            
            <div class="mt-2">
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        </div>
        
        <div class="flex flex-col items-end">
            <div class="text-lg font-bold text-gray-800 mb-2">
                ${{ number_format($booking->total_price, 2) }}
            </div>
            <div class="text-sm text-gray-500 mb-2">
                Мест забронировано: {{ $booking->seats }}
            </div>
            
            <div class="flex space-x-2">
                @if($booking->ticket)
                    <a href="{{ route('tickets.show', $booking->ticket) }}" 
                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Открыть билет
                    </a>
                @endif
                
                <a href="{{ $booking instanceof \App\Models\Booking ? route('cruises.show', $booking->cruiseLine) : route('voyages.show', $booking->voyage) }}" 
                   class="inline-flex items-center px-3 py-1 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                    @if($booking instanceof \App\Models\Booking)
                        Информация о круизе
                    @else 
                        Информация о рейсе
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>
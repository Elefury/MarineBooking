<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Ваш билет</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Детали</h2>
                            <p><span class="font-medium">Номер билета:</span> {{ $ticket->ticket_number }}</p>
                            <p><span class="font-medium">Статус:</span> 
                                <span class="px-2 py-1 rounded-full text-xs 
                                    {{ $ticket->status === 'issued' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </p>          
                                              
                            @if($ticket->bookable instanceof \App\Models\Booking)
                                <div class="cruise-details">
                                    @isset($ticket->bookable->cruiseLine)
                                        <h2>{{ $ticket->bookable->cruiseLine->name }}</h2>
                                        <p>Время отправления: {{ $ticket->bookable->cruiseLine->departure_time->format('d M Y H:i') }}</p>
                                    @else
                                        <p>Информации о круизе нет.</p>
                                    @endisset
                                </div>
                            @elseif($ticket->bookable instanceof \App\Models\VoyageBooking)
                                
                                <div class="voyage-details">
                                    @isset($ticket->bookable->voyage)
                                        <h2>Рейс #{{ $ticket->bookable->voyage->voyage_number }}</h2>
                                        @isset($ticket->bookable->voyage->departurePort, $ticket->bookable->voyage->arrivalPort)
                                            <p>Направление: 
                                                {{ $ticket->bookable->voyage->departurePort->name }} → 
                                                {{ $ticket->bookable->voyage->arrivalPort->name }}
                                            </p>
                                        @endisset
                                    @else
                                        <p>Информации о рейсе нет.</p>
                                    @endisset
                                </div>
                            @endif
                            
                        </div>
                        
                        <div class="flex flex-col items-center">
                            <div class="mb-4">{!! $ticket->qr_code !!}</div>
                            <a href="{{ route('tickets.download', $ticket) }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Загрузить PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
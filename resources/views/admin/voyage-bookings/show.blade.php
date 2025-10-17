<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Детали бронирования (рейсы) #{{ $voyageBooking->id }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Информация о рейсе</h2>
                    <div class="space-y-2">
                        <p><strong>Рейс #:</strong> {{ $voyageBooking->voyage->voyage_number }}</p>
                        <p><strong>Судно:</strong> {{ $voyageBooking->voyage->vessel->name }}</p>
                        <p><strong>Отправление:</strong> 
                            {{ $voyageBooking->voyage->departurePort->name }} 
                            ({{ $voyageBooking->voyage->departure_time->format('d.m.Y H:i') }})
                        </p>
                        <p><strong>Прибытие:</strong> 
                            {{ $voyageBooking->voyage->arrivalPort->name }} 
                            ({{ $voyageBooking->voyage->arrival_time->format('d.m.Y H:i') }})
                        </p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Детали бронирования</h2>
                    <div class="space-y-2">
                        <p><strong>Имя пользователя:</strong> {{ $voyageBooking->user->name }}</p>
                        <p><strong>Эл. почта:</strong> {{ $voyageBooking->user->email }}</p>
                        <p><strong>Забронировано мест:</strong> {{ $voyageBooking->seats }}</p>
                        <p><strong>на общую стоимость:</strong> ${{ number_format($voyageBooking->total_price, 2) }}</p>
                        <p><strong>Статус:</strong> 
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($voyageBooking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($voyageBooking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $voyageBooking->status }}
                            </span>
                        </p>
                        <p><strong>Когда забронировано:</strong> {{ $voyageBooking->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Зарезервировано до:</strong> {{ $voyageBooking->reserved_until->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            @if($voyageBooking->status !== 'cancelled' && $voyageBooking->status !== 'confirmed' )
            <form action="{{ route('admin.voyage-bookings.cancel', $voyageBooking) }}" method="POST">
                @csrf
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600" 
                    onclick="return confirm('Отменить это бронирование?')">
                    Отменить
                </button>
            </form>
            @endif
            <form action="{{ route('admin.voyage-bookings.destroy', $voyageBooking) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" 
                    onclick="return confirm('Удалить это бронирование? Действие безвозратно!')">
                    Удалить
                </button>
            </form>
            <a href="{{ route('admin.voyage-bookings.index') }}" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Назад
            </a>
        </div>
    </div>
</x-app-layout>



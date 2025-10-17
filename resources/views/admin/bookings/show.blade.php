<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Детали бронирования (круизы) #{{ $booking->id }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Детали круиза</h2>
                    <div class="space-y-2">
                        <p><strong>Круиз:</strong> {{ $booking->cruiseLine->name }}</p>
                        <p><strong>Цена за место:</strong> ${{ number_format($booking->cruiseLine->price_per_seat, 2) }}</p>
                        <p><strong>Доступно мест:</strong> {{ $booking->cruiseLine->available_seats }}</p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Детали бронирования</h2>
                    <div class="space-y-2">
                        <p><strong>Имя пользователя:</strong> {{ $booking->user->name }}</p>
                        <p><strong>Эл. почта:</strong> {{ $booking->user->email }}</p>
                        <p><strong>Забронировано мест:</strong> {{ $booking->seats }}</p>
                        <p><strong>на общую стоимость:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                        <p><strong>Статус:</strong> 
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $booking->status }}
                            </span>
                        </p>
                        <p><strong>Когда забронировано:</strong> {{ $booking->created_at->format('d.m.Y H:i') }}</p>
                        @if($booking->reserved_until)
                        <p><strong>Зарезервировано до:</strong> {{ $booking->reserved_until->format('d.m.Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            @if($booking->status !== 'cancelled' && $booking->status !== 'confirmed')
            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                @csrf
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600" 
                    onclick="return confirm('Отменить это бронирование?')">
                    Отменить
                </button>
            </form>
            @endif
            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" 
                    onclick="return confirm('Удалить это бронирование? Действие безвозвратно!')">
                    Удалить
                </button>
            </form>
            <a href="{{ route('admin.bookings.index') }}" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Назад
            </a>
        </div>
    </div>
</x-app-layout>
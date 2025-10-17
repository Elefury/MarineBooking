<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Voyage Bookings Management</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Имя пользователя</th>
                        <th class="py-3 px-6 text-left">Рейс</th>
                        <th class="py-3 px-6 text-left">Места</th>
                        <th class="py-3 px-6 text-left">Общая стоимость</th>
                        <th class="py-3 px-6 text-left">Статус</th>
                        <th class="py-3 px-6 text-left">Действия</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($bookings as $booking)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $booking->id }}</td>
                        <td class="py-3 px-6">{{ $booking->user->name }}</td>
                        <td class="py-3 px-6">
                            {{ $booking->voyage->voyage_number }} ({{ $booking->voyage->vessel->name }})
                        </td>
                        <td class="py-3 px-6">{{ $booking->seats }}</td>
                        <td class="py-3 px-6">${{ number_format($booking->total_price, 2) }}</td>
                        <td class="py-3 px-6">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="py-3 px-6 flex gap-2">
                            <a href="{{ route('admin.voyage-bookings.show', $booking) }}" 
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Открыть
                            </a>
                            @if($booking->status !== 'cancelled' && $booking->status !== 'confirmed')
                            <form action="{{ route('admin.voyage-bookings.cancel', $booking) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-amber-500 text-white px-3 py-1 rounded hover:bg-amber-600" 
                                    onclick="return confirm('Отменить это бронирование?')">
                                    Отменить
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.voyage-bookings.destroy', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" 
                                    onclick="return confirm('Удалить это бронирование? Действие безвозвратно!')">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center">Нет бронирований</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>
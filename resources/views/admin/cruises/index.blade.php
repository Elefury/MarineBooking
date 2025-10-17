<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Менеджмент круизов</h1>
            <a href="{{ route('admin.cruises.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Создать новый круиз
            </a>
        </div>

        <form method="GET" class="mb-4">
            <input 
                type="text" 
                name="search" 
                placeholder="Поиск..." 
                class="w-full p-2 border rounded"
                value="{{ request('search') }}"
            >
        </form>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($cruises->count())
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="px-4 py-2 text-left">Наименование</th>
                            <th class="px-4 py-2 text-left">Судно</th>
                            <th class="px-4 py-2 text-left">Время отправления</th>
                            <th class="px-4 py-2 text-left">Место встречи</th>
                            <th class="px-4 py-2 text-left">Места (свободные/всего)</th>
                            <th class="px-4 py-2 text-left">Цена</th>
                            <th class="px-4 py-2 text-left">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cruises as $cruise)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $cruise->name }}</td>
                                <td class="px-4 py-2">
                                    @if($cruise->vessel)
                                        {{ $cruise->vessel->name }} ({{ $cruise->vessel->type }})
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $cruise->departure_time->format('d.m.Y H:i') }}</td>
                                <td class="px-4 py-2">{{ $cruise->meeting_point ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span @class([
                                        'font-semibold',
                                        'text-green-600' => $cruise->available_seats > $cruise->total_seats*0.25,
                                        'text-yellow-600' => $cruise->available_seats > 0 && $cruise->available_seats <= $cruise->total_seats*0.25,
                                        'text-red-600' => $cruise->available_seats == 0
                                    ])>
                                        {{ $cruise->available_seats }}
                                    </span>
                                    / {{ $cruise->total_seats }}
                                </td>
                                <td class="px-4 py-2">${{ number_format($cruise->price_per_seat, 2) }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('admin.cruises.edit', $cruise) }}" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Изменить
                                    </a>
                                    <form action="{{ route('admin.cruises.destroy', $cruise) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Вы уверены? Все связанные бронирования будут удалены.')">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $cruises->links() }}
            </div>
        @else
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">
                    @if(request('search'))
                        Ничего не найдено по запросу "{{ request('search') }}"
                    @else
                        Нет доступных круизов
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
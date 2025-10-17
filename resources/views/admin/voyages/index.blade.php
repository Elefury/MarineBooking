<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Менеджмент рейсов</h1>
            <a href="{{ route('admin.voyages.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Создать новый рейс
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

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($voyages->count())
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="px-4 py-2 text-left">Рейс #</th>
                            <th class="px-4 py-2 text-left">Судно</th>
                            <th class="px-4 py-2 text-left">Точка и время отправления</th>
                            <th class="px-4 py-2 text-left">Точка и время прибытия</th>
                            <th class="px-4 py-2 text-left">Места (свободные/всего)</th>
                            <th class="px-4 py-2 text-left">Цена</th>
                            <th class="px-4 py-2 text-left">Тип рейса</th>
                            <th class="px-4 py-2 text-left">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($voyages as $voyage)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $voyage->voyage_number }}</td>
                                <td class="px-4 py-2">{{ $voyage->vessel->name }}</td>
                                <td class="px-4 py-2">
                                    {{ $voyage->departurePort->name }}<br>
                                    <small>{{ $voyage->departure_time->format('d.m.Y H:i') }}</small>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $voyage->arrivalPort->name }}<br>
                                    <small>{{ $voyage->arrival_time->format('d.m.Y H:i') }}</small>
                                </td>
                                <td class="px-4 py-2">
                                    <span @class([
                                        'font-semibold',
                                        'text-green-600' => $voyage->available_seats > $voyage->passenger_capacity*0.25,
                                        'text-yellow-600' => $voyage->available_seats > 0 && $voyage->available_seats <= $voyage->passenger_capacity*0.25,
                                        'text-red-600' => $voyage->available_seats == 0
                                    ])>
                                        {{ $voyage->available_seats }}
                                    </span>
                                    / {{ $voyage->passenger_capacity }}
                                </td>
                                <td class="px-4 py-2">${{ number_format($voyage->price_per_seat, 2) }}</td>
                                <td class="px-4 py-2">{{ ucfirst($voyage->type) }}</td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('admin.voyages.edit', $voyage) }}" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Изменить
                                    </a>
                                    <form action="{{ route('admin.voyages.destroy', $voyage) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Вы уверены?')">
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
                {{ $voyages->links() }}
            </div>
        @else
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">
                    @if(request('search'))
                        Нет результатов по запросу "{{ request('search') }}"
                    @else
                        Нет доступных рейсов.
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
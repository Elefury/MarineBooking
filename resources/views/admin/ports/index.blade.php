<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Менеджмент портов</h1>
            <a href="{{ route('admin.ports.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Добавить порт
            </a>
        </div>

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

        @if($ports->count())
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="px-4 py-2 text-left">Наименование</th>
                            <th class="px-4 py-2 text-left">Город</th>
                            <th class="px-4 py-2 text-left">Страна</th>
                            <th class="px-4 py-2 text-left">Координаты</th>
                            <th class="px-4 py-2 text-left">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($ports as $port)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $port->name }}</td>
                                <td class="px-4 py-2">{{ $port->city }}</td>
                                <td class="px-4 py-2">{{ $port->country }}</td>
                                <td class="px-4 py-2">
                                    @if($port->latitude && $port->longitude)
                                        {{ $port->latitude }}, {{ $port->longitude }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('admin.ports.edit', $port) }}" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Изменить
                                    </a>
                                    <form action="{{ route('admin.ports.destroy', $port) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Вы уверены, что хотите удалить этот порт?')">
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
                {{ $ports->links() }}
            </div>
        @else
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Портов нет</p>
            </div>
        @endif
    </div>
</x-app-layout>
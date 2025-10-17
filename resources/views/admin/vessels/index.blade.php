<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Менеджмент водного транспорта</h1>
            <a href="{{ route('admin.vessels.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Добавить новое судно
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 ">
                {{ session('error') }}
            </div>
        @endif

        @if($vessels->count())
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="px-4 py-2 text-left">Наименование</th>
                            <th class="px-4 py-2 text-left">Тип</th>
                            <th class="px-4 py-2 text-left">Вместимость (чел.)</th>
                            <th class="px-4 py-2 text-left">Описание</th>
                            <th class="px-4 py-2 text-left">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($vessels as $vessel)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $vessel->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($vessel->type) }}</td>
                                <td class="px-4 py-2">{{ $vessel->capacity }}</td>
                                <td class="px-4 py-2">{{ Str::limit($vessel->description, 50) }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('admin.vessels.edit', $vessel) }}" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Изменить
                                    </a>
                                    <form action="{{ route('admin.vessels.destroy', $vessel) }}" method="POST">
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
                {{ $vessels->links() }}
            </div>
        @else
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Ни одного судна не найдено</p>
            </div>
        @endif
    </div>
</x-app-layout>
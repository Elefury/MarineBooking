<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Редактирование данных о судне</h1>

        <form action="{{ route('admin.vessels.update', $vessel) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-gray-700">Наименование</label>
                    <input type="text" name="name" value="{{ $vessel->name }}" required
                        class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block text-gray-700">Тип</label>
                    <input type="text" name="type" value="{{ $vessel->type }}" required
                        class="w-full p-2 border rounded" placeholder="e.g. Ferry, Yacht, Speedboat">
                </div>

                <div>
                    <label class="block text-gray-700">Вместимость (чел.)</label>
                    <input type="number" name="capacity" value="{{ $vessel->capacity }}" required min="1"
                        class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block text-gray-700">Описание</label>
                    <textarea name="description" class="w-full p-2 border rounded">{{ $vessel->description }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Сохранить
                    </button>
                    <a href="{{ route('admin.vessels.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Отменить
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Добавление нового водного транспорта</h1>

        <form action="{{ route('admin.vessels.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700">Наименование</label>
                    <input type="text" name="name" required
                        class="w-full p-2 border rounded">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Тип</label>
                    <input type="text" name="type" required
                        class="w-full p-2 border rounded" placeholder="e.g. Ferry, Yacht, Speedboat">
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Вместимость (чел.)</label>
                    <input type="number" name="capacity" required min="1"
                        class="w-full p-2 border rounded">
                    @error('capacity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Описание</label>
                    <textarea name="description" class="w-full p-2 border rounded"></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Создать
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
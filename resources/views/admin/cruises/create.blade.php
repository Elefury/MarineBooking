<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Создание нового круиза</h1>

        <form action="{{ route('admin.cruises.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Наименование*</label>
                        <input type="text" name="name" required 
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Используемое судно*</label>
                        <select name="vessel_id" required class="w-full p-2 border rounded">
                            <option value="">Выберите судно</option>
                            @foreach($vessels as $vessel)
                                <option value="{{ $vessel->id }}">{{ $vessel->name }} ({{ $vessel->type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Место встречи*</label>
                        <input type="text" name="meeting_point" required 
                            class="w-full p-2 border rounded">
                        @error('meeting_point')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-gray-700">Широта точки встречи</label>
                            <input type="number" step="0.000001" name="meeting_latitude" 
                                value="{{ old('meeting_latitude', $cruise->meeting_latitude ?? '') }}"
                                class="w-full p-2 border rounded">
                            @error('meeting_latitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">Долгота точки встречи</label>
                            <input type="number" step="0.000001" name="meeting_longitude" 
                                value="{{ old('meeting_longitude', $cruise->meeting_longitude ?? '') }}"
                                class="w-full p-2 border rounded">
                            @error('meeting_longitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700">Время отправления*</label>
                        <input type="datetime-local" name="departure_time" required
                            class="w-full p-2 border rounded">
                    </div>

                    <!-- <div>
                        <label class="block text-gray-700">Image URL</label>
                        <input type="url" name="image_url" 
                            class="w-full p-2 border rounded">
                    </div> -->

                    <div>
                        <label class="block text-gray-700">URL изображения</label>
                        <input type="url" name="image_url" 
                            value="{{ old('image_url', $cruise->image_url ?? '') }}"
                            class="w-full p-2 border rounded">
                        @error('image_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Цена за место*</label>
                        <input type="number" step="0.01" name="price_per_seat" required min="0"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Максимум свободных мест</label>
                        <input type="number" name="total_seats" required min="1"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Тип круиза</label>
                        <select name="type" required class="w-full p-2 border rounded">
                            <option value="regular">Regular</option>
                            <option value="cruise">Cruise</option>
                            <option value="charter">Charter</option>
                        </select>
                    </div>

                </div>

                <div>
                    <label class="block text-gray-700">Описание*</label>
                    <textarea name="description" required rows="4" class="w-full p-2 border rounded"></textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Создать
                    </button>
                    <a href="{{ route('admin.cruises.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Отменить
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
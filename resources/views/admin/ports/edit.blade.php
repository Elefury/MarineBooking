<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Редактирование порта</h1>

        <form action="{{ route('admin.ports.update', $port) }}" method="POST">
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Наименование</label>
                        <input type="text" name="name" value="{{ old('name', $port->name) }}" required
                            class="w-full p-2 border rounded">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Город</label>
                        <input type="text" name="city" value="{{ old('city', $port->city) }}" required
                            class="w-full p-2 border rounded">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Страна</label>
                        <input type="text" name="country" value="{{ old('country', $port->country) }}" required
                            class="w-full p-2 border rounded">
                        @error('country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Широта</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $port->latitude) }}"
                            class="w-full p-2 border rounded" placeholder="e.g. 45.5017">
                        @error('latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Долгота</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $port->longitude) }}"
                            class="w-full p-2 border rounded" placeholder="e.g. -73.5673">
                        @error('longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Изменить
                    </button>
                    <a href="{{ route('admin.ports.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Отменить
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
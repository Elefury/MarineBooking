<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Создание нового рейса</h1>

        <form action="{{ route('admin.voyages.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Рейс #</label>
                        <input type="text" name="voyage_number" required 
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Судно</label>
                        <select name="vessel_id" required class="w-full p-2 border rounded">
                            <option value="">Выберите судно</option>
                            @foreach($vessels as $vessel)
                                <option value="{{ $vessel->id }}">{{ $vessel->name }} ({{ $vessel->type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Порт - точка отправления</label>
                        <select name="departure_port_id" required class="w-full p-2 border rounded">
                            <option value="">Select Port</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}">{{ $port->name }}, {{ $port->city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Порт - точка прибытия</label>
                        <select name="arrival_port_id" required class="w-full p-2 border rounded">
                            <option value="">Select Port</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}">{{ $port->name }}, {{ $port->city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Время отправления</label>
                        <input type="datetime-local" name="departure_time" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Время прибытия</label>
                        <input type="datetime-local" name="arrival_time" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Максимум свободных мест</label>
                        <input type="number" name="passenger_capacity" required min="1"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Цена за место</label>
                        <input type="number" step="0.01" name="price_per_seat" required min="0"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Тип рейса</label>
                        <select name="type" required class="w-full p-2 border rounded">
                            <option value="regular">Regular</option>
                            <option value="cruise">Cruise</option>
                            <option value="charter">Charter</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Создать
                    </button>
                    <a href="{{ route('admin.voyages.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Отменить
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
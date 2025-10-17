<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Редактирование данных рейса</h1>

        <form action="{{ route('admin.voyages.update', $voyage) }}" method="POST">
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
                        <label class="block text-gray-700">Рейс #</label>
                        <input type="text" name="voyage_number" value="{{ $voyage->voyage_number }}" required 
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Судно</label>
                        <select name="vessel_id" required class="w-full p-2 border rounded">
                            <option value="">Выберите судно</option>
                            @foreach($vessels as $vessel)
                                <option value="{{ $vessel->id }}" {{ $voyage->vessel_id == $vessel->id ? 'selected' : '' }}>
                                    {{ $vessel->name }} ({{ $vessel->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Порт - точка отправления</label>
                        <select name="departure_port_id" required class="w-full p-2 border rounded">
                            <option value="">Выберите порт</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ $voyage->departure_port_id == $port->id ? 'selected' : '' }}>
                                    {{ $port->name }}, {{ $port->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Порт - точка прибытия</label>
                        <select name="arrival_port_id" required class="w-full p-2 border rounded">
                            <option value="">Выберите порт</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}" {{ $voyage->arrival_port_id == $port->id ? 'selected' : '' }}>
                                    {{ $port->name }}, {{ $port->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Время отправления</label>
                        <input type="datetime-local" name="departure_time" 
                            value="{{ $voyage->departure_time->format('Y-m-d\TH:i') }}" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Время прибытия</label>
                        <input type="datetime-local" name="arrival_time" 
                            value="{{ $voyage->arrival_time->format('Y-m-d\TH:i') }}" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Максимум свобондых мест</label>
                        <input type="number" name="passenger_capacity" 
                            value="{{ $voyage->passenger_capacity }}" required min="1"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Цена за место</label>
                        <input type="number" step="0.01" name="price_per_seat" 
                            value="{{ $voyage->price_per_seat }}" required min="0"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Тип рейса</label>
                        <select name="type" required class="w-full p-2 border rounded">
                            <option value="regular" {{ $voyage->type == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="cruise" {{ $voyage->type == 'cruise' ? 'selected' : '' }}>Cruise</option>
                            <option value="charter" {{ $voyage->type == 'charter' ? 'selected' : '' }}>Charter</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.voyages.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
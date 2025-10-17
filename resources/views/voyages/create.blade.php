<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Create New Voyage</h1>

        <form action="{{ route('admin.voyages.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Voyage Number</label>
                        <input type="text" name="voyage_number" required 
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Vessel</label>
                        <select name="vessel_id" required class="w-full p-2 border rounded">
                            <option value="">Select Vessel</option>
                            @foreach($vessels as $vessel)
                                <option value="{{ $vessel->id }}">{{ $vessel->name }} ({{ $vessel->type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Departure Port</label>
                        <select name="departure_port_id" required class="w-full p-2 border rounded">
                            <option value="">Select Port</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}">{{ $port->name }}, {{ $port->city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Arrival Port</label>
                        <select name="arrival_port_id" required class="w-full p-2 border rounded">
                            <option value="">Select Port</option>
                            @foreach($ports as $port)
                                <option value="{{ $port->id }}">{{ $port->name }}, {{ $port->city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Departure Time</label>
                        <input type="datetime-local" name="departure_time" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Arrival Time</label>
                        <input type="datetime-local" name="arrival_time" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Passenger Capacity</label>
                        <input type="number" name="passenger_capacity" required min="1"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Price per Seat ($)</label>
                        <input type="number" step="0.01" name="price_per_seat" required min="0"
                            class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700">Type</label>
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
                        Create Voyage
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
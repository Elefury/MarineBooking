<div>
    <input 
        type="text" 
        wire:model.live="search" 
        placeholder="Search cruises..."
        class="w-full p-2 border rounded mb-4"
    >

    <div wire:loading class="text-gray-500 mb-4">Searching...</div>

    @if($cruises->count() > 0)
        <div class="bg-white shadow-sm sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Departure Time</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cruises as $cruise)
                        <tr wire:key="cruise-{{ $cruise->id }}">
                            <td class="px-4 py-2">{{ $cruise->name }}</td>
                            <td class="px-4 py-2">{{ $cruise->departure_time->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-2">${{ number_format($cruise->price_per_seat, 2) }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a 
                                    href="{{ route('admin.cruises.edit', $cruise) }}" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                >
                                    Edit
                                </a>
                                <form 
                                    action="{{ route('admin.cruises.destroy', $cruise) }}" 
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                        onclick="return confirm('Delete this cruise?')"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cruises->links() }}
        </div>
    @else
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">
                @if($this->search)
                    No results for "{{ $this->search }}"
                @else
                    No cruises available
                @endif
            </p>
        </div>
    @endif
</div>
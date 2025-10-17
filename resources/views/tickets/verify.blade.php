<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Verify Ticket</h1>
                    
                    <form method="POST" action="{{ route('tickets.verify-check') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="ticket_number" class="block text-gray-700">Ticket Number</label>
                            <input type="text" name="ticket_number" id="ticket_number" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                                   required autofocus>
                        </div>
                        
                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Verify Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto mt-4">
    <div class="bg-gradient-to-r from-blue-600 to-green-500 p-6 text-white">
        <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h2 class="text-2xl font-bold">Бронирование: круиз "{{ $cruise->name }}"</h2>
        </div>
        @if($cruise->departure_time)
            <p class="mt-2 opacity-90">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Время отправления: {{ $cruise->departure_time->format('d M Y, H:i') }}
            </p>
        @else
            <p class="mt-2 opacity-90">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Время отправления не указано.
            </p>
        @endif
    </div>

    <div class="p-6 space-y-6">
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <label class="block text-gray-700 font-medium mb-3">Выберите кол-во мест для брони</label>
            <div class="flex items-center space-x-4">
                <input 
                    type="number" 
                    wire:model.live="seats" 
                    min="1" 
                    max="{{ min($cruise->available_seats, 8) }}"
                    oninput="this.value = this.value ? Math.max(1, Math.min({{ min($cruise->available_seats, 8) }}, parseInt(this.value) || 1)) : 1"
                    class="w-24 p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-center font-bold"
                    wire:change="calculateTotal"
                >
                <span class="text-gray-500">Max: {{ min($cruise->available_seats, 8) }} мест</span>
            </div>
            @error('seats') 
                <div class="mt-2 flex items-center text-red-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Блок стоимости -->
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <p class="text-gray-600">Цена за место:</p>
                <p class="text-2xl font-bold text-blue-600">${{ number_format($cruise->price_per_seat, 2) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <p class="text-gray-600">Итоговая цена:</p>
                <p class="text-2xl font-bold text-green-600">${{ number_format($totalPrice, 2) }}</p>
            </div>
        </div>

        <button 
            wire:click="initiatePayment" 
            wire:loading.attr="disabled"
            class="w-full flex justify-center items-center space-x-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white py-4 px-6 rounded-lg shadow-md transition-all transform hover:scale-[1.02]"
        >
            <span wire:loading.remove>Перейти к оплате</span>
            <span wire:loading>
                Обработка...
            </span>
            <svg wire:loading class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>

        @if($stripeError)
            <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="font-medium text-red-800">Payment Error</h3>
                    <p class="text-red-600">{{ $stripeError }}</p>
                </div>
            </div>
        @endif

        <div class="text-center text-gray-500 text-sm mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $cruise->available_seats }} доступных мест осталось
        </div>
    </div>
</div>
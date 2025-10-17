<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow rounded-lg p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Оставить отзыв</h1>
                
                <form method="POST" action="{{ route('reviews.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Ваша оценка</label>
                        <div class="flex items-center space-x-2" x-data="{ rating: {{ old('rating', 0) }} }">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" 
                                       class="hidden" x-model="rating">
                                <label for="star{{$i}}" 
                                       class="text-3xl cursor-pointer"
                                       :class="{
                                           'text-yellow-400': {{$i}} <= rating,
                                           'text-gray-300': {{$i}} > rating
                                       }">
                                    ★
                                </label>
                            @endfor
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                        @error('rating')
                            <p class="text-sm text-red-600">Пожалуйста, выберите оценку</p>
                        @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="content" class="block text-lg font-medium text-gray-700">Текст отзыва</label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="6"
                            required
                            maxlength="1000"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                            placeholder="Поделитесь вашими впечатлениями..."
                        >{{ old('content') }}</textarea>
                        <p class="text-sm text-gray-500">Осталось: <span id="chars-counter">1000</span> символов</p>
                        @error('content')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Отправить отзыв
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('content').addEventListener('input', function() {
            const max = 1000;
            const remaining = max - this.value.length;
            document.getElementById('chars-counter').textContent = remaining;
        });
    </script>
</x-app-layout>
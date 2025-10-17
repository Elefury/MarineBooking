<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Добавление нового FAQ</h2>
                
                <form method="POST" action="{{ route('admin.faq.store') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="question" class="block text-sm font-medium text-gray-700">Вопрос *</label>
                            <input type="text" id="question" name="question" value="{{ old('question') }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        
                        <div>
                            <label for="answer" class="block text-sm font-medium text-gray-700">Ответ *</label>
                            <textarea id="answer" name="answer" rows="5" 
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('answer') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Порядок</label>
                                <input type="number" id="order" name="order" value="{{ old('order', 0) }}" 
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            
                            <div class="flex items-center">
                                <input type="hidden" name="is_active" value="0"> <!-- Важно: перед чекбоксом! -->
                                <input id="is_active" name="is_active" type="checkbox" value="1"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                       {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">Активный</label>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('admin.faq.index') }}" 
                               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md inline-flex items-center">
                                Отмена
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Сохранить FAQ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
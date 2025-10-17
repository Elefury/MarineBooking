<x-app-layout>
    <div class="py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Управление разделом "Часто задаваемые вопросы" (FAQ)</h1>
                <a href="{{ route('admin.faq.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                    
                    Добавить FAQ
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Вопрос</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ответ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Порядок</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($faqs as $faq)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 max-w-xs truncate">{{ $faq->question }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                    <div class="faq-answer truncate-multiline">
                                        {{ $faq->answer }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $faq->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $faq->is_active ? 'Активен' : 'Неактивен' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $faq->order }}</td>
                                <td class="px-6 py-6 flex gap-2">
                                    <a href="{{ route('admin.faq.edit', $faq) }}" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                        Изменить
                                    </a>
                                    <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600"
                                            onclick="return confirm('Вы уверены?')">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
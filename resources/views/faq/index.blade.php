
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Часто задаваемые вопросы</h1>
                <p class="text-xl text-gray-600">Найдите ответы на популярные вопросы о наших услугах</p>
            </div>

            <div class="space-y-6">
                @foreach($faqs as $faq)
                <div x-data="{ open: false }" class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button 
                        @click="open = !open" 
                        class="w-full px-6 py-5 text-left focus:outline-none"
                    >
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $faq->question }}</h3>
                            <svg 
                                :class="{ 'transform rotate-180': open }" 
                                class="w-5 h-5 text-blue-500 transition-transform duration-200" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    
                    <div x-show="open" x-collapse class="px-6 pb-5 text-gray-600">
                        <div class="prose max-w-none">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($faqs->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <p class="text-gray-500">Пока нет часто задаваемых вопросов. Проверьте позже.</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-3xl font-bold text-gray-900">Отзывы наших клиентов</h1>
                
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="mr-2 text-sm text-gray-600">Сортировка:</span>
                        <select 
                            onchange="window.location.href = '{{ route('reviews.index') }}?sort=' + this.value"
                            class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Сначала новые</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                            <option value="highest" {{ $sort === 'highest' ? 'selected' : '' }}>Высокий рейтинг</option>
                            <option value="lowest" {{ $sort === 'lowest' ? 'selected' : '' }}>Низкий рейтинг</option>
                        </select>
                    </div>
                    
                    @auth
                        <a href="{{ route('reviews.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg shadow transition duration-150 whitespace-nowrap">
                            Оставить отзыв
                        </a>
                    @endauth
                </div>
            </div>

            @if($reviews->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500 text-lg">Пока нет отзывов. Будьте первым!</p>
                </div>
            @else
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($reviews as $review)
<div class="review-card bg-white p-6 rounded-lg shadow mb-4">
    <div class="flex flex-col sm:flex-row">
        <div class="review-text-container flex-1">
            <div class="flex items-start justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-semibold">{{ $review->user->name }}</h4>
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                </div>
                <span class="text-sm text-gray-400">
                    {{ $review->created_at->translatedFormat('d M Y H:i') }}
                </span>
            </div>
            <p class="mt-4 text-gray-600 review-content">
                {{ $review->content }}
            </p>

            @if(auth()->check() && auth()->user()->is_admin)
                <div class="mt-4 flex justify-end">
                    <form method="POST" 
                          action="{{ route('admin.reviews.destroy', $review) }}" 
                          onsubmit="return confirm('Удалить этот отзыв?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 hover:text-red-800 text-sm font-medium transition duration-150">
                            Удалить отзыв
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
                        @endforeach
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4">
                        {{ $reviews->appends(['sort' => $sort])->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
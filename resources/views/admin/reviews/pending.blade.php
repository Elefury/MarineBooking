<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold mb-4">Отзывы на модерации</h1>
                
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600 whitespace-nowrap">Сортировка:</span>
                    <select 
                        onchange="window.location.href = '{{ route('admin.reviews.pending') }}?sort=' + this.value"
                        class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Новые</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Старые</option>
                        <option value="highest" {{ $sort === 'highest' ? 'selected' : '' }}>Высокий рейтинг</option>
                        <option value="lowest" {{ $sort === 'lowest' ? 'selected' : '' }}>Низкий рейтинг</option>
                    </select>
                </div>
            </div>

@forelse($reviews as $review)
<div class="review-card bg-white p-6 rounded-lg shadow mb-4">
    <div class="flex flex-col sm:flex-row">
        <div class="review-text-container flex-1">
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <div class="text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                </div>
                <span class="font-medium">{{ $review->user->name }}</span>
                <span class="text-sm text-gray-500">
                    {{ $review->created_at->translatedFormat('d M Y H:i') }}
                </span>
            </div>
            <p class="text-gray-600 review-content">
                {{ $review->content }}
            </p>
        </div>
        
        <div class="review-actions flex flex-row sm:flex-col gap-2 mt-4 sm:mt-0 sm:ml-4">
            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                @csrf
                <button type="submit" 
                        class="w-full sm:w-auto text-green-600 hover:text-green-800 px-3 py-1 rounded bg-green-50 hover:bg-green-100 transition whitespace-nowrap">
                    Одобрить
                </button>
            </form>
            
            <form method="POST" 
                  action="{{ route('admin.reviews.destroy', $review) }}" 
                  onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?')">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="w-full sm:w-auto text-red-600 hover:text-red-800 px-3 py-1 rounded bg-red-50 hover:bg-red-100 transition whitespace-nowrap">
                    Удалить
                </button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="bg-white p-6 rounded-lg shadow text-center">
    <p class="text-gray-500">Нет отзывов для модерации</p>
</div>
@endforelse
            @if($reviews->hasPages())
                <div class="mt-6 px-4 py-3 bg-white border-t border-gray-200 sm:px-6 rounded-b-lg">
                    {{ $reviews->appends(['sort' => $sort])->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
        
        $reviews = Review::where('is_approved', true)
            ->when($sort === 'highest', fn($q) => $q->orderBy('rating', 'desc'))
            ->when($sort === 'lowest', fn($q) => $q->orderBy('rating', 'asc'))
            ->when($sort === 'oldest', fn($q) => $q->orderBy('created_at', 'asc'))
            ->when($sort === 'latest', fn($q) => $q->latest())
            ->with('user')
            ->paginate(10)
            ->appends(['sort' => $sort]);

        return view('reviews.index', compact('reviews', 'sort'));
    }

    public function pending(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        
        $reviews = Review::where('is_approved', false)
            ->when($sort === 'highest', fn($q) => $q->orderBy('rating', 'desc'))
            ->when($sort === 'lowest', fn($q) => $q->orderBy('rating', 'asc'))
            ->when($sort === 'oldest', fn($q) => $q->orderBy('created_at', 'asc'))
            ->when($sort === 'newest', fn($q) => $q->latest())
            ->with('user')
            ->paginate(10)
            ->appends(['sort' => $sort]);

        return view('admin.reviews.pending', compact('reviews', 'sort'));
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|min:10|max:1000',
            'rating' => 'required|integer|between:1,5'
        ], [
            'rating.required' => 'Пожалуйста, выберите оценку',
            'rating.between' => 'Оценка должна быть от 1 до 5'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'is_approved' => false
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Ваш отзыв отправлен на модерацию. Спасибо!');
    }

    public function approve(Review $review)
    {
        if ($review->is_approved) {
            return back()->with('error', 'Этот отзыв уже одобрен');
        }

        $review->update(['is_approved' => true]);
        
        return back()->with('success', 'Отзыв одобрен и опубликован');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Отзыв удален');
    }
}
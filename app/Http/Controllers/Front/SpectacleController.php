<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Spectacle;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpectacleController extends Controller
{
    public function index(Request $request)
    {
        $query = Spectacle::where('is_active', true);

        // Фильтрация по дате
        if ($request->has('date') && $request->date) {
            $query->whereHas('shows', function ($q) use ($request) {
                $q->whereDate('start_time', $request->date);
            });
        }

        // Фильтрация по жанру
        if ($request->has('genre') && $request->genre) {
            $query->where('genre', $request->genre);
        }

        // Фильтрация по возрастному ограничению
        if ($request->has('age') && $request->age) {
            $query->where('age_limit', '<=', $request->age);
        }

        // Поиск по названию
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('title_tatar', 'like', '%' . $request->search . '%');
            });
        }

        $spectacles = $query->with(['shows' => function($q) {
            $q->where('start_time', '>', now())->orderBy('start_time');
        }])->paginate(12);
        
        $genres = Spectacle::distinct()->pluck('genre');
        $ageLimits = ['0+', '6+', '12+', '16+', '18+']; // Добавляем переменную ageLimits

        return view('front.spectacles.index', compact('spectacles', 'genres', 'ageLimits'));
    }

    public function show($id)
    {
        $spectacle = Spectacle::with(['actors', 'reviews.user', 'shows' => function ($query) {
            $query->where('start_time', '>', now())
                  ->orderBy('start_time');
        }])->findOrFail($id);

        $relatedSpectacles = Spectacle::where('genre', $spectacle->genre)
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('front.spectacles.show', compact('spectacle', 'relatedSpectacles'));
    }

    public function addReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000'
        ]);

        $spectacle = Spectacle::findOrFail($id);

        $review = Review::create([
            'spectacle_id' => $spectacle->id,
            'user_id' => auth()->id(),
            'author_name' => auth()->user()->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false
        ]);

        return back()->with('success', 'Спасибо за отзыв! Он будет опубликован после модерации.');
    }
}
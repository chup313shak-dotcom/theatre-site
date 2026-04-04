<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Spectacle;
use App\Models\News;
use App\Models\Actor;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingShows = Spectacle::with('shows')
            ->whereHas('shows', function ($query) {
                $query->where('start_time', '>', now());
            })
            ->take(5)
            ->get();

        $news = News::latest()->take(3)->get();
        $actors = Actor::take(4)->get(); // Берем 4 артиста для главной

        return view('front.home', compact('upcomingShows', 'news', 'actors'));
    }
}
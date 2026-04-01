<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Spectacle;
use App\Models\News;

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

        $news = News::latest()->take(4)->get();

        return view('front.home', compact('upcomingShows', 'news'));
    }
}
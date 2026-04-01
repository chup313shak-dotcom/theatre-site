<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->latest()->paginate(12);
        return view('front.news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::published()->findOrFail($id);
        $relatedNews = News::published()
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        return view('front.news.show', compact('news', 'relatedNews'));
    }
}
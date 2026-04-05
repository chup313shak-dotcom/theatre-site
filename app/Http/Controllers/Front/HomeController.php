<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Spectacle;
use App\Models\News;
use App\Models\Actor;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

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

    public function about()
    {
        return view('front.about');
    }

    public function contacts()
    {
        return view('front.contacts');
    }

    public function subscribe(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        
        // Сохраняем в таблицу подписок
        Subscription::updateOrCreate(
            ['email' => $email],
            [
                'is_active' => true,
                'user_id' => Auth::id()
            ]
        );

        // Если пользователь авторизован, обновляем его флаг в таблице users
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->email === $email) {
                $user->update(['is_subscribed' => true]);
            }
        }
        
        return back()->with('success', 'Вы успешно подписались на наши новости!');
    }
}
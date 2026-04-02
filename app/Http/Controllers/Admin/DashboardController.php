<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spectacle;
use App\Models\Show;
use App\Models\Order;
use App\Models\User;
use App\Models\News;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'spectacles_count' => Spectacle::count(),
            'shows_count' => Show::count(),
            'orders_count' => Order::count(),
            'users_count' => User::count(),
            'news_count' => News::count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
        ];

        // Аналитика за последние 7 дней (выручка)
        $revenueData = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $upcomingShows = Show::with('spectacle')->where('start_time', '>=', now())->orderBy('start_time')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'upcomingShows', 'revenueData'));
    }
}
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
        $spectaclesCount = Spectacle::count();
        $showsCount = Show::count();
        $ordersCount = Order::count();
        $usersCount = User::count();
        
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'spectaclesCount', 
            'showsCount', 
            'ordersCount', 
            'usersCount', 
            'recentOrders'
        ));
    }
}

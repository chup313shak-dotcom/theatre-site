<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Spectacle;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Главная страница личного кабинета
     */
    public function index()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        $ordersCount = Order::where('user_id', $user->id)->count();
        
        return view('front.profile.index', compact('user', 'recentOrders', 'ordersCount'));
    }

    /**
     * История покупок
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['tickets', 'tickets.show', 'tickets.show.spectacle'])
            ->latest()
            ->paginate(10);
            
        return view('front.profile.orders', compact('orders'));
    }

    /**
     * Детали заказа
     */
    public function orderDetails($orderId)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->with(['tickets', 'tickets.show', 'tickets.show.spectacle'])
            ->findOrFail($orderId);
            
        return view('front.profile.order-details', compact('order'));
    }

    /**
     * Редактирование профиля
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('front.profile.edit', compact('user'));
    }

    /**
     * Обновление профиля
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
        // Обновление пароля
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Текущий пароль неверен']);
            }
            $user->password = Hash::make($request->new_password);
        }
        
        // Обновление подписки на рассылку
        if ($request->has('is_subscribed')) {
            $user->is_subscribed = $request->boolean('is_subscribed');
        }
        
        $user->save(); // Исправлено: добавлен вызов метода ()
        
        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен');
    }

    /**
     * Скачать билет в PDF
     */
    public function downloadTicket($ticketId)
    {
        try {
            $user = Auth::user();
            
            // Находим билет, принадлежащий пользователю
            $ticket = Ticket::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['show', 'show.spectacle'])->findOrFail($ticketId);
            
            // Проверяем, что билет оплачен
            if ($ticket->order->status !== 'paid') {
                return back()->with('error', 'Билет не оплачен');
            }
            
            // Генерируем PDF
            $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
            
            // Скачиваем файл
            return $pdf->download('ticket_' . $ticket->id . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('Failed to download ticket', [
                'ticket_id' => $ticketId,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Не удалось скачать билет');
        }
    }
    
    /**
     * Просмотр билета в браузере
     */
    public function viewTicket($ticketId)
    {
        try {
            $user = Auth::user();
            
            $ticket = Ticket::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['show', 'show.spectacle'])->findOrFail($ticketId);
            
            if ($ticket->order->status !== 'paid') {
                return back()->with('error', 'Билет не оплачен');
            }
            
            $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
            
            return $pdf->stream('ticket_' . $ticket->id . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('Failed to view ticket', [
                'ticket_id' => $ticketId,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Не удалось открыть билет');
        }
    }
}
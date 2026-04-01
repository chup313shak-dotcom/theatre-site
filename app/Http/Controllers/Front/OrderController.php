<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Show;
use App\Models\Ticket;
use App\Models\SeatReservation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TicketMail;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Страница оформления заказа
     */
    public function checkout($orderId)
    {
        $order = Order::with(['tickets', 'tickets.show', 'tickets.show.spectacle'])
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);
        
        // Получаем резервируемые места
        $reservations = SeatReservation::where('order_id', $order->id)
            ->with('show')
            ->get();
        
        if ($reservations->isEmpty()) {
            return redirect()->route('spectacles.index')
                ->with('error', 'Заказ не найден');
        }
        
        $show = $reservations->first()->show;
        $totalAmount = 0;
        
        foreach ($reservations as $reservation) {
            $price = $show->getSeatPrice($reservation->row, $reservation->seat);
            $totalAmount += $price;
        }
        
        // Проверяем, истекло ли время (но НЕ делаем редирект)
        $isExpired = false;
        if ($order->payment_expires_at) {
            $isExpired = Carbon::now()->gt($order->payment_expires_at);
        }
        
        return view('front.checkout.index', compact('order', 'reservations', 'show', 'totalAmount', 'isExpired'));
    }

    /**
     * Продление времени резерва
     */
    public function extend($orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($orderId);
        
        $timeout = 1800; // 30 минут
        $newExpiryTime = Carbon::now()->addSeconds($timeout);
        
        $order->update(['payment_expires_at' => $newExpiryTime]);
        SeatReservation::where('order_id', $order->id)
            ->update(['expires_at' => $newExpiryTime]);
        
        return response()->json([
            'success' => true,
            'expires_at' => $newExpiryTime,
            'expires_at_formatted' => $newExpiryTime->format('Y-m-d H:i:s'),
            'message' => 'Время резерва продлено на 30 минут'
        ]);
    }

    /**
     * Обработка оплаты
     */
    public function processPayment(Request $request, $orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($orderId);
        
        // Проверяем время - если истекло, возвращаем ошибку
        if ($order->payment_expires_at && Carbon::now()->gt($order->payment_expires_at)) {
            return redirect()->route('spectacles.index')
                ->with('error', 'Время резерва истекло. Пожалуйста, выберите места заново.');
        }
            
        $request->validate([
            'payment_method' => 'required|in:online,cash'
        ]);
        
        // Имитация оплаты
        sleep(1);
        
        $order->update([
            'payment_method' => $request->payment_method,
            'payment_id' => 'PAY_' . strtoupper(Str::random(10)),
            'status' => 'paid'
        ]);
        
        return $this->completeOrder($order);
    }
    
    private function completeOrder($order)
    {
        $reservations = SeatReservation::where('order_id', $order->id)->get();
        
        if ($reservations->isEmpty()) {
            return redirect()->route('home')->with('error', 'Ошибка: места не найдены');
        }
        
        $totalAmount = 0;
        
        foreach ($reservations as $reservation) {
            $show = Show::find($reservation->show_id);
            $price = $show->getSeatPrice($reservation->row, $reservation->seat);
            
            Ticket::create([
                'order_id' => $order->id,
                'show_id' => $reservation->show_id,
                'row' => $reservation->row,
                'seat' => $reservation->seat,
                'price' => $price,
                'qr_code' => Str::random(32),
                'is_used' => false
            ]);
            
            $totalAmount += $price;
        }
        
        $order->update(['total_amount' => $totalAmount]);
        SeatReservation::where('order_id', $order->id)->delete();
        
        $this->generateTickets($order);
        $this->sendTicketEmail($order);
        
        return redirect()->route('order.success', $order->id)
            ->with('success', 'Билеты успешно оплачены!');
    }
    
    private function generateTickets($order)
    {
        $ticketDir = storage_path('app/tickets');
        if (!file_exists($ticketDir)) {
            mkdir($ticketDir, 0755, true);
        }
        
        foreach ($order->tickets as $ticket) {
            try {
                $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
                $pdfPath = storage_path('app/tickets/ticket_' . $ticket->id . '.pdf');
                $pdf->save($pdfPath);
            } catch (\Exception $e) {
                Log::error('Failed to generate ticket PDF', ['error' => $e->getMessage()]);
            }
        }
    }
    
    private function sendTicketEmail($order)
    {
        try {
            if (empty($order->customer_email)) {
                return;
            }
            Mail::to($order->customer_email)->send(new TicketMail($order));
        } catch (\Exception $e) {
            Log::error('Failed to send email', ['error' => $e->getMessage()]);
        }
    }
    
    public function success($orderId)
    {
        $order = Order::with(['tickets', 'tickets.show', 'tickets.show.spectacle'])
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);
            
        return view('front.checkout.success', compact('order'));
    }
    
    public function viewTicket($ticketId)
    {
        $user = auth()->user();
        $ticket = Ticket::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['show', 'show.spectacle'])->findOrFail($ticketId);
        
        if ($ticket->order->status !== 'paid') {
            return back()->with('error', 'Билет не оплачен');
        }
        
        $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
        return $pdf->stream('ticket_' . $ticket->id . '.pdf');
    }
    
    public function downloadTicket($ticketId)
    {
        $user = auth()->user();
        $ticket = Ticket::whereHas('order', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['show', 'show.spectacle'])->findOrFail($ticketId);
        
        if ($ticket->order->status !== 'paid') {
            return back()->with('error', 'Билет не оплачен');
        }
        
        $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }
    
    public function cancel($orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($orderId);
            
        $order->update(['status' => 'cancelled']);
        SeatReservation::where('order_id', $order->id)->delete();
        
        return redirect()->route('home')->with('success', 'Заказ отменен');
    }
}
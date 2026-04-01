<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Show;
use App\Models\Order;
use App\Models\SeatReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ShowController extends Controller
{
    /**
     * Получить схему зала для выбранного показа
     */
    public function getSeats($id)
    {
        $show = Show::with('spectacle')->findOrFail($id);
        
        $hallSchema = $show->hall_schema ?? $this->getDefaultHallSchema();
        $occupiedSeats = $this->getOccupiedSeats($show);
        
        foreach ($hallSchema['rows'] as &$row) {
            foreach ($row['seats'] as &$seat) {
                $key = $row['row'] . '_' . $seat['number'];
                if (isset($occupiedSeats[$key])) {
                    $seat['status'] = $occupiedSeats[$key];
                } else {
                    $seat['status'] = 'available';
                }
            }
        }

        return response()->json([
            'success' => true,
            'hall_schema' => $hallSchema,
            'prices' => $show->prices,
            'reservation_timeout' => config('theatre.reservation_timeout', 1800),
            'show_id' => $show->id,
            'spectacle_title' => $show->spectacle->title,
            'start_time' => $show->start_time->format('d.m.Y H:i')
        ]);
    }
    
    /**
     * Резервирование мест
     */
    public function reserveSeats(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Необходимо авторизоваться'], 401);
        }

        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*.row' => 'required|string',
            'seats.*.seat' => 'required|integer'
        ]);

        $show = Show::findOrFail($id);
        $sessionId = session()->getId();
        $timeout = config('theatre.reservation_timeout', 1800);

        // Проверяем доступность мест
        $occupiedSeats = $this->getOccupiedSeats($show);
        
        foreach ($request->seats as $seat) {
            $key = $seat['row'] . '_' . $seat['seat'];
            if (isset($occupiedSeats[$key])) {
                return response()->json([
                    'error' => 'Место ' . $seat['row'] . $seat['seat'] . ' уже занято'
                ], 409);
            }
        }

        // Создаем заказ
        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone,
            'total_amount' => 0,
            'status' => 'pending',
            'payment_expires_at' => Carbon::now()->addSeconds($timeout)
        ]);

        // Резервируем места
        foreach ($request->seats as $seat) {
            SeatReservation::create([
                'show_id' => $show->id,
                'row' => $seat['row'],
                'seat' => $seat['seat'],
                'order_id' => $order->id,
                'session_id' => $sessionId,
                'expires_at' => Carbon::now()->addSeconds($timeout)
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'expires_at' => $order->payment_expires_at,
            'redirect_url' => route('checkout', $order->id)
        ]);
    }
    
    /**
     * Продление времени резерва
     */
    public function extendReservation($orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($orderId);
        
        $timeout = config('theatre.reservation_timeout', 1800);
        $newExpiryTime = Carbon::now()->addSeconds($timeout);
        
        $order->update(['payment_expires_at' => $newExpiryTime]);
        
        // Обновляем резервации
        SeatReservation::where('order_id', $order->id)
            ->update(['expires_at' => $newExpiryTime]);
        
        return response()->json([
            'success' => true,
            'expires_at' => $newExpiryTime,
            'message' => 'Время резерва продлено на ' . floor($timeout / 60) . ' минут'
        ]);
    }
    
    /**
     * Получить занятые места
     */
    private function getOccupiedSeats($show)
    {
        $occupied = [];
        
        // Оплаченные билеты
        $tickets = $show->tickets()->get();
        foreach ($tickets as $ticket) {
            $occupied[$ticket->row . '_' . $ticket->seat] = 'sold';
        }
        
        // Активные резервации
        $reservations = $show->seatReservations()
            ->where('expires_at', '>', Carbon::now())
            ->get();
        foreach ($reservations as $reservation) {
            $occupied[$reservation->row . '_' . $reservation->seat] = 'reserved';
        }
        
        return $occupied;
    }
    
    /**
     * Стандартная схема зала
     */
    private function getDefaultHallSchema()
    {
        $rows = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
        $seatsPerRow = [20, 20, 18, 18, 16, 16, 14, 14, 12, 12];
        
        $hallSchema = ['rows' => []];
        
        foreach ($rows as $index => $row) {
            $seats = [];
            for ($i = 1; $i <= $seatsPerRow[$index]; $i++) {
                $seats[] = ['number' => $i, 'status' => 'available'];
            }
            $hallSchema['rows'][] = ['row' => $row, 'seats' => $seats];
        }
        
        return $hallSchema;
    }
}
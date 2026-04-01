<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SeatReservation;
use App\Models\Order;
use Carbon\Carbon;

class ClearExpiredReservations extends Command
{
    protected $signature = 'reservations:clear-expired';
    protected $description = 'Clear expired seat reservations';

    public function handle()
    {
        // Удаляем просроченные резервации
        $expiredReservations = SeatReservation::where('expires_at', '<', Carbon::now())->get();
        
        foreach ($expiredReservations as $reservation) {
            // Отменяем связанный заказ
            if ($reservation->order_id) {
                $order = Order::find($reservation->order_id);
                if ($order && $order->status === 'pending') {
                    $order->update(['status' => 'expired']);
                }
            }
            $reservation->delete();
        }
        
        // Удаляем просроченные заказы без резерваций
        Order::where('status', 'pending')
            ->where('payment_expires_at', '<', Carbon::now())
            ->update(['status' => 'expired']);
        
        $this->info('Expired reservations cleared: ' . count($expiredReservations));
    }
}
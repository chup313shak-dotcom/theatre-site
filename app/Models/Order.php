<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'total_amount', 'status', 'payment_method', 'payment_id', 'payment_expires_at', 'metadata'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'payment_expires_at' => 'datetime',
        'metadata' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'pending' => 'В обработке',
            'paid' => 'Оплачен',
            'cancelled' => 'Отменен',
            default => $this->status,
        };
    }

    public function markAsPaid($paymentId = null)
    {
        $this->update([
            'status' => 'paid',
            'payment_id' => $paymentId,
            'payment_expires_at' => null
        ]);

        // Освобождаем временные резервации
        SeatReservation::where('order_id', $this->id)->delete();
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
        
        // Возвращаем билеты
        foreach ($this->tickets as $ticket) {
            $ticket->delete();
        }
        
        // Освобождаем резервации
        SeatReservation::where('order_id', $this->id)->delete();
    }
}
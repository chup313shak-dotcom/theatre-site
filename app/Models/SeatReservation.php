<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeatReservation extends Model
{
    protected $fillable = [
        'show_id', 'row', 'seat', 'order_id', 'session_id', 'expires_at'
    ];
    
    protected $casts = [
        'expires_at' => 'datetime'
    ];
    
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    
    // Удаляем просроченные резервации
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
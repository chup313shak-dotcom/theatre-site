<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'order_id', 'show_id', 'row', 'seat', 'zone', 'price', 'qr_code', 'is_used', 'used_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_used' => 'boolean',
        'used_at' => 'datetime'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function generateQrCode()
    {
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)
            ->generate(json_encode([
                'ticket_id' => $this->id,
                'show_id' => $this->show_id,
                'seat' => $this->row . $this->seat,
                'qr_code' => $this->qr_code
            ]));
    }
}
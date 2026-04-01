<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Show extends Model
{
    protected $fillable = [
        'spectacle_id', 'start_time', 'end_time', 'prices', 'hall_schema', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'prices' => 'array',
        'hall_schema' => 'array'
    ];

    public function spectacle(): BelongsTo
    {
        return $this->belongsTo(Spectacle::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function seatReservations(): HasMany
    {
        return $this->hasMany(SeatReservation::class);
    }

    public function getAvailableSeats()
    {
        $occupiedSeats = $this->tickets()->pluck('seat', 'row')->toArray();
        $reservedSeats = $this->seatReservations()
            ->where('expires_at', '>', now())
            ->pluck('seat', 'row')
            ->toArray();

        return array_merge($occupiedSeats, $reservedSeats);
    }

    public function isSeatAvailable($row, $seat): bool
    {
        $isSold = $this->tickets()->where('row', $row)->where('seat', $seat)->exists();
        $isReserved = $this->seatReservations()
            ->where('row', $row)
            ->where('seat', $seat)
            ->where('expires_at', '>', now())
            ->exists();

        return !$isSold && !$isReserved;
    }


public function getSeatPrice($row, $seat)
{
    $prices = $this->prices;
    
    if (!$prices) return 500;
    
    foreach ($prices as $zone => $zoneData) {
        if (isset($zoneData['rows']['from']) && isset($zoneData['rows']['to'])) {
            $rowNum = (int)$row;
            if ($rowNum >= $zoneData['rows']['from'] && $rowNum <= $zoneData['rows']['to']) {
                return $zoneData['price'] ?? 500;
            }
        }
    }
    
    return $prices['default']['price'] ?? 500;
}
}
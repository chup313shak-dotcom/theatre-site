<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    protected $fillable = [
        'name', 'name_tatar', 'photo', 'biography', 'category', 'awards'
    ];

    protected $casts = [
        'awards' => 'array', // Это автоматически преобразует JSON в массив
    ];

    public function spectacles(): BelongsToMany
    {
        return $this->belongsToMany(Spectacle::class)->withPivot('role');
    }

    public function getCurrentSeasonRoles()
    {
        return $this->spectacles()
            ->whereHas('shows', function ($query) {
                $query->whereYear('start_time', now()->year);
            })
            ->get();
    }
    
    public static function getCategories()
    {
        return [
            'Народный артист' => 'Народный артист',
            'Заслуженный артист' => 'Заслуженный артист',
            'Артист' => 'Артист'
        ];
    }
    
    // Безопасное получение наград
    public function getAwardsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        
        return $value;
    }
    
    // Проверка, есть ли награды
    public function hasAwards()
    {
        $awards = $this->awards;
        return !empty($awards) && count($awards) > 0;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spectacle extends Model
{
    protected $fillable = [
        'title', 'title_tatar', 'description', 'director', 'duration',
        'genre', 'age_limit', 'poster', 'gallery', 'rating', 'reviews_count', 'is_active'
    ];

    protected $casts = [
        'gallery' => 'array',
        'rating' => 'float'
    ];

    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class)->withPivot('role');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getUpcomingShows()
    {
        return $this->shows()->where('start_time', '>', now())->orderBy('start_time')->get();
    }
}
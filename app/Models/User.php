<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone', 
        'is_subscribed',
        'role'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_subscribed' => 'boolean'
    ];

    // Отношения
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Spectacle::class, 'favorites');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    // Методы для работы с избранным
    public function isFavorite($spectacleId)
    {
        return $this->favorites()->where('spectacle_id', $spectacleId)->exists();
    }
    
    public function toggleFavorite($spectacleId)
    {
        if ($this->isFavorite($spectacleId)) {
            $this->favorites()->detach($spectacleId);
            return false;
        } else {
            $this->favorites()->attach($spectacleId);
            return true;
        }
    }
    
    // Методы для работы с ролями (если используете простую систему)
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isManager()
    {
        return $this->role === 'manager';
    }
}
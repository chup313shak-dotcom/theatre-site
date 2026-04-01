<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'title_tatar', 'content', 'image', 'published_at', 'is_published'
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean'
    ];
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }
    
    // Если нужно добавить данные вручную
    public static function createTestData()
    {
        // Создаем тестовую новость, если нет данных
        if (self::count() == 0) {
            self::create([
                'title' => 'Добро пожаловать в наш театр!',
                'title_tatar' => 'Театрыбызга рәхим итегез!',
                'content' => '<p>Мы рады приветствовать вас на нашем новом сайте! Теперь вы можете покупать билеты онлайн, знакомиться с афишей и узнавать последние новости театра.</p><p>Ждем вас на наших спектаклях!</p>',
                'image' => null,
                'published_at' => now(),
                'is_published' => true
            ]);
        }
    }
}
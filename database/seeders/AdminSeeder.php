<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@theatre.ru'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('admin123'),
                'phone' => '+7 (000) 000-00-00',
                'role' => 'admin',
                'is_subscribed' => true
            ]
        );
    }
}
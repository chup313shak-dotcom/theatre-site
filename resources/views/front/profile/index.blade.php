<!-- resources/views/front/profile/index.blade.php -->
@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Личный кабинет</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Боковое меню -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="text-center mb-4">
                        <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-user text-4xl text-gray-500"></i>
                        </div>
                        <h3 class="font-bold text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('profile') }}" 
                           class="block px-4 py-2 bg-red-50 text-red-600 rounded-lg font-medium">
                            <i class="fas fa-tachometer-alt mr-2"></i> Главная
                        </a>
                        <a href="{{ route('profile.orders') }}" 
                           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-ticket-alt mr-2"></i> Мои билеты
                        </a>
                        <a href="{{ route('profile.favorites') }}" 
                           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-heart mr-2"></i> Избранное
                            @if($favoritesCount > 0)
                                <span class="float-right bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                    {{ $favoritesCount }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-user-edit mr-2"></i> Редактировать профиль
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded-lg transition text-red-600">
                                <i class="fas fa-sign-out-alt mr-2"></i> Выйти
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
            
            <!-- Основной контент -->
            <div class="md:col-span-3">
                <!-- Статистика -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-md p-4 text-white">
                        <i class="fas fa-ticket-alt text-3xl mb-2"></i>
                        <h3 class="text-2xl font-bold">{{ $ordersCount }}</h3>
                        <p class="text-sm opacity-90">Всего билетов</p>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-4 text-white">
                        <i class="fas fa-heart text-3xl mb-2"></i>
                        <h3 class="text-2xl font-bold">{{ $favoritesCount }}</h3>
                        <p class="text-sm opacity-90">В избранном</p>
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-4 text-white">
                        <i class="fas fa-calendar-alt text-3xl mb-2"></i>
                        <h3 class="text-2xl font-bold">{{ $recentOrders->count() }}</h3>
                        <p class="text-sm opacity-90">Ближайшие спектакли</p>
                    </div>
                </div>
                
                <!-- Последние заказы -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Последние заказы</h2>
                        <a href="{{ route('profile.orders') }}" class="text-red-600 hover:underline text-sm">
                            Все заказы →
                        </a>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentOrders as $order)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold">Заказ #{{ $order->id }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $order->created_at->format('d.m.Y H:i') }}
                                            </p>
                                            <p class="text-sm mt-1">
                                                Сумма: <span class="font-bold">{{ number_format($order->total_amount, 2) }} ₽</span>
                                            </p>
                                            <span class="inline-block px-2 py-1 text-xs rounded-full mt-2
                                                @if($order->status == 'paid') bg-green-100 text-green-700
                                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif">
                                                @if($order->status == 'paid') Оплачен
                                                @elseif($order->status == 'pending') Ожидает оплаты
                                                @else Отменен @endif
                                            </span>
                                        </div>
                                        <a href="{{ route('profile.order.details', $order->id) }}" 
                                           class="text-red-600 hover:underline text-sm">
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            У вас пока нет заказов. 
                            <a href="{{ route('spectacles.index') }}" class="text-red-600 hover:underline">
                                Перейти к афише
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
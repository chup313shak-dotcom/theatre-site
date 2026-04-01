<!-- resources/views/front/profile/order-details.blade.php -->
@extends('layouts.app')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Заказ #{{ $order->id }}</h1>
            <a href="{{ route('profile.orders') }}" class="text-red-600 hover:underline">
                ← Назад к заказам
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Информация о заказе -->
            <div class="bg-gray-50 p-6 border-b">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Дата заказа</p>
                        <p class="font-semibold">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Статус</p>
                        <span class="inline-block px-2 py-1 text-xs rounded-full
                            @if($order->status == 'paid') bg-green-100 text-green-700
                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            @if($order->status == 'paid') Оплачен
                            @elseif($order->status == 'pending') Ожидает оплаты
                            @else Отменен @endif
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Способ оплаты</p>
                        <p class="font-semibold">{{ $order->payment_method == 'online' ? 'Онлайн' : 'В кассе' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Билеты -->
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Билеты</h2>
                
                <div class="space-y-4">
                    @foreach($order->tickets as $ticket)
                        <div class="border rounded-lg p-4 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg">{{ $ticket->show->spectacle->title }}</h3>
                                <p class="text-gray-600 text-sm">
                                    {{ $ticket->show->start_time->format('d.m.Y') }} в {{ $ticket->show->start_time->format('H:i') }}
                                </p>
                                <p class="text-gray-600 text-sm">
                                    Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}
                                </p>
                                <p class="font-semibold mt-2">{{ number_format($ticket->price, 2) }} ₽</p>
                            </div>
                            
                            <div class="text-right">
                                @if($order->status == 'paid')
                                    <a href="{{ route('profile.download.ticket', $ticket->id) }}" 
                                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                        <i class="fas fa-download mr-1"></i> Скачать PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-4 border-t text-right">
                    <p class="text-xl font-bold">Итого: {{ number_format($order->total_amount, 2) }} ₽</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
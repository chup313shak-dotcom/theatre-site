<!-- resources/views/front/profile/order-details.blade.php -->
@extends('layouts.app')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
<div class="container">
    <div class="">
        <div class="">
            <h1 class="">Заказ #{{ $order->id }}</h1>
            <a href="{{ route('profile.orders') }}" class="">
                ← Назад к заказам
            </a>
        </div>
        
        <div class="">
            <!-- Информация о заказе -->
            <div class="">
                <div class="">
                    <div>
                        <p class="">Дата заказа</p>
                        <p class="">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="">Статус</p>
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
                        <p class="">Способ оплаты</p>
                        <p class="">{{ $order->payment_method == 'online' ? 'Онлайн' : 'В кассе' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Билеты -->
            <div class="">
                <h2 class="">Билеты</h2>
                
                <div class="">
                    @foreach($order->tickets as $ticket)
                        <div class="">
                            <div class="">
                                <h3 class="">{{ $ticket->show->spectacle->title }}</h3>
                                <p class="">
                                    {{ $ticket->show->start_time->format('d.m.Y') }} в {{ $ticket->show->start_time->format('H:i') }}
                                </p>
                                <p class="">
                                    Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}
                                </p>
                                <p class="">{{ number_format($ticket->price, 2) }} ₽</p>
                            </div>
                            
                            <div class="text-right">
                                @if($order->status == 'paid')
                                    <a href="{{ route('profile.download.ticket', $ticket->id) }}" 
                                       class="">
                                        <i class="fas fa-download"></i> Скачать PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-right">
                    <p class="">Итого: {{ number_format($order->total_amount, 2) }} ₽</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
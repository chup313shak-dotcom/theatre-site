<!-- resources/views/front/profile/orders.blade.php -->
@extends('layouts.app')

@section('title', 'Мои билеты')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Мои билеты</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Боковое меню -->
            <div class="md:col-span-1">
                @include('front.profile.partials.sidebar')
            </div>
            
            <!-- Список заказов -->
            <div class="md:col-span-3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">История покупок</h2>
                    
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start flex-wrap gap-4">
                                        <div class="flex-1">
                                            <p class="font-semibold text-lg">Заказ #{{ $order->id }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $order->created_at->format('d.m.Y H:i') }}
                                            </p>
                                            <p class="text-sm mt-2">
                                                <strong>Сумма:</strong> {{ number_format($order->total_amount, 2) }} ₽
                                            </p>
                                            <p class="text-sm">
                                                <strong>Способ оплаты:</strong> 
                                                {{ $order->payment_method == 'online' ? 'Онлайн' : 'В кассе' }}
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
                                        
                                        <div class="text-right">
                                            <a href="{{ route('profile.order.details', $order->id) }}" 
                                               class="inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                                Подробнее
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Список билетов в заказе -->
                                    <div class="mt-3 pt-3 border-t">
                                        <p class="text-sm font-medium mb-2">Билеты:</p>
                                        <div class="space-y-1">
                                            @foreach($order->tickets as $ticket)
                                                <div class="text-sm text-gray-600">
                                                    🎭 {{ $ticket->show->spectacle->title }} — 
                                                    {{ $ticket->show->start_time->format('d.m.Y H:i') }} — 
                                                    Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}
                                                    @if($ticket->is_used)
                                                        <span class="text-green-600 ml-2">(Использован)</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $orders->links() }}
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
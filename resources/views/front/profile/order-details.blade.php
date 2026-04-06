@extends('layouts.app')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <link rel="stylesheet" href="{{ asset('css/order-details.css') }}">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-ticket-alt text-red-600"></i>
                Заказ #{{ $order->id }}
            </h1>
            <a href="{{ route('profile.orders') }}" class="inline-flex items-center text-gray-500 hover:text-red-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к заказам
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-5 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-red-600 text-lg"></i>
                        <div>
                            <p class="text-xs text-gray-500">ДАТА ЗАКАЗА</p>
                            <p class="font-semibold">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas {{ $order->status == 'paid' ? 'fa-check-circle text-green-600' : ($order->status == 'pending' ? 'fa-clock text-yellow-600' : 'fa-times-circle text-red-600') }} text-lg"></i>
                        <div>
                            <p class="text-xs text-gray-500">СТАТУС</p>
                            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                @if($order->status == 'paid') bg-green-100 text-green-700
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ $order->status == 'paid' ? 'Оплачен' : ($order->status == 'pending' ? 'Ожидает оплаты' : 'Отменен') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-credit-card text-purple-600 text-lg"></i>
                        <div>
                            <p class="text-xs text-gray-500">СПОСОБ ОПЛАТЫ</p>
                            <p class="font-semibold">{{ $order->payment_method == 'online' ? 'Онлайн' : 'В кассе' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-ticket-alt text-red-600 text-xl"></i>
                        <h2 class="text-xl font-bold">Билеты</h2>
                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $order->tickets->count() }} шт.</span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @foreach($order->tickets as $ticket)
                    <div class="border rounded-xl p-4 hover:shadow-md transition bg-white">
                        <div class="flex flex-wrap justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-theater-masks text-red-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $ticket->show->spectacle->title }}</h3>
                                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1 text-sm text-gray-500">
                                            <span><i class="fas fa-calendar-alt mr-1"></i> {{ $ticket->show->start_time->format('d.m.Y') }}</span>
                                            <span><i class="fas fa-clock mr-1"></i> {{ $ticket->show->start_time->format('H:i') }}</span>
                                            <span><i class="fas fa-chair mr-1"></i> Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="inline-block bg-red-50 text-red-700 px-3 py-1 rounded-lg font-semibold">
                                                {{ number_format($ticket->price, 2) }} ₽
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($order->status == 'paid')
                            <div class="flex-shrink-0">
                                <a href="{{ route('profile.download.ticket', $ticket->id) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-download"></i> Скачать PDF
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-4 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Итого:</span>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($order->total_amount, 2) }} ₽</p>
                    </div>
                </div>
            </div>
            
            @if($order->status == 'paid')
            <div class="bg-green-50 px-6 py-4 border-t border-green-100">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope text-green-600"></i>
                    <p class="text-sm text-green-800">Билеты отправлены на email: <strong>{{ $order->customer_email }}</strong></p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
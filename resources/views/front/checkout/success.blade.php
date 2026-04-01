<!-- resources/views/front/checkout/success.blade.php -->
@extends('layouts.app')

@section('title', 'Билеты оплачены')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Успешная оплата -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8 text-center">
            <div class="text-green-500 mb-4">
                <i class="fas fa-check-circle text-6xl"></i>
            </div>
            <h1 class="text-3xl font-bold mb-2">Оплата прошла успешно!</h1>
            <p class="text-gray-600 mb-4">
                Спасибо за покупку! Ваши билеты готовы.
            </p>
            <div class="bg-gray-50 rounded-lg p-4 inline-block">
                <p class="font-semibold">Номер заказа: #{{ $order->id }}</p>
                <p class="text-sm text-gray-600">Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}</p>
                <p class="text-sm text-gray-600">Сумма: {{ number_format($order->total_amount, 2) }} ₽</p>
            </div>
        </div>
        
        <!-- Билеты -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">Ваши билеты</h2>
            
            @foreach($order->tickets as $ticket)
                <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Информация о спектакле -->
                        <div class="md:col-span-2">
                            <h3 class="font-bold text-xl mb-2">{{ $ticket->show->spectacle->title }}</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-600">Дата и время:</p>
                                    <p class="font-semibold">{{ $ticket->show->start_time->format('d.m.Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Место:</p>
                                    <p class="font-semibold">Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Режиссер:</p>
                                    <p class="font-semibold">{{ $ticket->show->spectacle->director }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Цена:</p>
                                    <p class="font-semibold text-red-600">{{ number_format($ticket->price, 2) }} ₽</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QR-код и кнопки -->
                        <div class="text-center">
                            <div class="mb-3">
                                {!! QrCode::size(100)->generate(json_encode([
                                    'ticket_id' => $ticket->id,
                                    'show_id' => $ticket->show_id,
                                    'seat' => $ticket->row . $ticket->seat,
                                    'spectacle' => $ticket->show->spectacle->title,
                                    'date' => $ticket->show->start_time->format('d.m.Y H:i')
                                ])) !!}
                            </div>
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('order.view.ticket', $ticket->id) }}" 
                                   target="_blank"
                                   class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition">
                                    <i class="fas fa-eye mr-1"></i> Просмотр
                                </a>
                                <a href="{{ route('order.download.ticket', $ticket->id) }}" 
                                   class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700 transition">
                                    <i class="fas fa-download mr-1"></i> Скачать PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Информация и кнопки -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
            <div class="flex items-start">
                <i class="fas fa-envelope text-blue-600 text-xl mr-3 mt-1"></i>
                <div>
                    <p class="font-semibold text-blue-800">Билеты отправлены на почту</p>
                    <p class="text-blue-700 text-sm">
                        Копия билетов отправлена на адрес {{ $order->customer_email }}.
                        Если вы не получили письмо, проверьте папку "Спам".
                    </p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('profile.orders') }}" 
               class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-ticket-alt mr-2"></i> Мои билеты
            </a>
            <a href="{{ route('spectacles.index') }}" 
               class="border border-red-600 text-red-600 px-6 py-3 rounded-lg hover:bg-red-50 transition">
                <i class="fas fa-calendar-alt mr-2"></i> Перейти к афише
            </a>
        </div>
        
        <!-- Инструкция -->
        <div class="mt-8 p-4 bg-gray-50 rounded-lg text-center text-sm text-gray-600">
            <i class="fas fa-mobile-alt mr-2"></i>
            Для входа в театр предъявите электронный билет на экране телефона или распечатанную версию.
            <br>
            Пожалуйста, прибывайте в театр за 30 минут до начала спектакля.
        </div>
    </div>
</div>
@endsection
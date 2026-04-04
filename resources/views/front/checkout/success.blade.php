<!-- resources/views/front/checkout/success.blade.php -->
@extends('layouts.app')

@section('title', 'Билеты оплачены')

@section('content')
<div class="container">
    <div class="">
        <!-- Успешная оплата -->
        <div class="text-center">
            <div class="">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="">Оплата прошла успешно!</h1>
            <p class="">
                Спасибо за покупку! Ваши билеты готовы.
            </p>
            <div class="">
                <p class="">Номер заказа: #{{ $order->id }}</p>
                <p class="">Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}</p>
                <p class="">Сумма: {{ number_format($order->total_amount, 2) }} ₽</p>
            </div>
        </div>
        
        <!-- Билеты -->
        <div class="">
            <h2 class="">Ваши билеты</h2>
            
            @foreach($order->tickets as $ticket)
                <div class="">
                    <div class="">
                        <!-- Информация о спектакле -->
                        <div class="">
                            <h3 class="">{{ $ticket->show->spectacle->title }}</h3>
                            <div class="">
                                <div>
                                    <p class="">Дата и время:</p>
                                    <p class="">{{ $ticket->show->start_time->format('d.m.Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="">Место:</p>
                                    <p class="">Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}</p>
                                </div>
                                <div>
                                    <p class="">Режиссер:</p>
                                    <p class="">{{ $ticket->show->spectacle->director }}</p>
                                </div>
                                <div>
                                    <p class="">Цена:</p>
                                    <p class="">{{ number_format($ticket->price, 2) }} ₽</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QR-код и кнопки -->
                        <div class="text-center">
                            <div class="">
                                {!! QrCode::size(100)->generate(json_encode([
                                    'ticket_id' => $ticket->id,
                                    'show_id' => $ticket->show_id,
                                    'seat' => $ticket->row . $ticket->seat,
                                    'spectacle' => $ticket->show->spectacle->title,
                                    'date' => $ticket->show->start_time->format('d.m.Y H:i')
                                ])) !!}
                            </div>
                            <div class="">
                                <a href="{{ route('order.view.ticket', $ticket->id) }}" 
                                   target="_blank"
                                   class="">
                                    <i class="fas fa-eye"></i> Просмотр
                                </a>
                                <a href="{{ route('order.download.ticket', $ticket->id) }}" 
                                   class="">
                                    <i class="fas fa-download"></i> Скачать PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Информация и кнопки -->
        <div class="">
            <div class="">
                <i class="fas fa-envelope"></i>
                <div>
                    <p class="">Билеты отправлены на почту</p>
                    <p class="">
                        Копия билетов отправлена на адрес {{ $order->customer_email }}.
                        Если вы не получили письмо, проверьте папку "Спам".
                    </p>
                </div>
            </div>
        </div>
        
        <div class="">
            <a href="{{ route('profile.orders') }}" 
               class="">
                <i class="fas fa-ticket-alt"></i> Мои билеты
            </a>
            <a href="{{ route('spectacles.index') }}" 
               class="">
                <i class="fas fa-calendar-alt"></i> Перейти к афише
            </a>
        </div>
        
        <!-- Инструкция -->
        <div class="text-center">
            <i class="fas fa-mobile-alt"></i>
            Для входа в театр предъявите электронный билет на экране телефона или распечатанную версию.
            <br>
            Пожалуйста, прибывайте в театр за 30 минут до начала спектакля.
        </div>
    </div>
</div>
@endsection
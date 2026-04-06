@extends('layouts.app')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
<div class="order-container">
    <div class="order-wrapper">
        <div class="order-head">
            <h1>Заказ №{{ $order->id }}</h1>
            <a href="{{ route('profile.orders') }}" class="back-link">Назад к заказам</a>
        </div>

        <div class="order-card">
            <!-- Информация о заказе -->
            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">Дата заказа</span>
                    <span class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Статус</span>
                    <span class="status-text 
                        @if($order->status == 'paid') status-paid
                        @elseif($order->status == 'pending') status-pending
                        @else status-cancelled @endif">
                        {{ $order->status == 'paid' ? 'Оплачен' : ($order->status == 'pending' ? 'Ожидает оплаты' : 'Отменён') }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Способ оплаты</span>
                    <span class="info-value">{{ $order->payment_method == 'online' ? 'Онлайн' : 'В кассе' }}</span>
                </div>
            </div>

            <!-- Билеты -->
            <div class="tickets-block">
                <div class="tickets-header">
                    <span class="tickets-title">Билеты</span>
                    <span class="tickets-count">{{ $order->tickets->count() }} шт.</span>
                </div>

                <div class="tickets-list">
                    @foreach($order->tickets as $ticket)
                    <div class="ticket-card">
                        <div class="ticket-main">
                            <div class="ticket-spectacle">{{ $ticket->show->spectacle->title }}</div>
                            <div class="ticket-meta">
                                <span>{{ $ticket->show->start_time->format('d.m.Y') }}</span>
                                <span>{{ $ticket->show->start_time->format('H:i') }}</span>
                                <span>Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}</span>
                            </div>
                            <div class="ticket-price">{{ number_format($ticket->price, 2) }} ₽</div>
                        </div>
                        @if($order->status == 'paid')
                        <div class="ticket-action">
                            <a href="{{ route('profile.download.ticket', $ticket->id) }}" class="download-link">Скачать PDF</a>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="order-total">
                    <span>Итого</span>
                    <strong>{{ number_format($order->total_amount, 2) }} ₽</strong>
                </div>
            </div>

            @if($order->status == 'paid')
            <div class="order-note">
                Билеты отправлены на email: {{ $order->customer_email }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .order-container {
        background: #f5f5f5;
        min-height: 100vh;
        padding: 2rem 1rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .order-wrapper {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Заголовок и навигация */
    .order-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .order-head h1 {
        font-size: 1.75rem;
        font-weight: 400;
        letter-spacing: -0.3px;
        color: #111;
        margin: 0;
    }

    .back-link {
        color: #555;
        text-decoration: none;
        font-size: 0.9rem;
        border-bottom: 1px solid #ccc;
        transition: color 0.2s, border-color 0.2s;
    }

    .back-link:hover {
        color: #000;
        border-bottom-color: #000;
    }

    /* Карточка заказа */
    .order-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    /* Информационная панель */
    .order-info {
        padding: 1.5rem;
        border-bottom: 1px solid #eaeaea;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        background: #fafafa;
    }

    .info-row {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #777;
    }

    .info-value {
        font-size: 1rem;
        color: #222;
        font-weight: 500;
    }

    .status-text {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        width: fit-content;
    }

    .status-paid {
        background: #e6e6e6;
        color: #1a1a1a;
        border-left: 3px solid #2c2c2c;
    }

    .status-pending {
        background: #f0f0f0;
        color: #666;
        border-left: 3px solid #999;
    }

    .status-cancelled {
        background: #f0f0f0;
        color: #a00;
        border-left: 3px solid #a00;
    }

    /* Блок билетов */
    .tickets-block {
        padding: 1.5rem;
    }

    .tickets-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eaeaea;
        margin-bottom: 1.5rem;
    }

    .tickets-title {
        font-size: 1.2rem;
        font-weight: 500;
        color: #111;
    }

    .tickets-count {
        font-size: 0.8rem;
        color: #666;
    }

    .tickets-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .ticket-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1rem;
        background: #fefefe;
        border: 1px solid #ededed;
        transition: background 0.1s;
    }

    .ticket-card:hover {
        background: #fcfcfc;
    }

    .ticket-main {
        flex: 1;
    }

    .ticket-spectacle {
        font-weight: 600;
        font-size: 1rem;
        color: #111;
        margin-bottom: 0.5rem;
    }

    .ticket-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .ticket-price {
        font-size: 0.9rem;
        font-weight: 500;
        color: #222;
        letter-spacing: 0.3px;
    }

    .ticket-action {
        flex-shrink: 0;
    }

    .download-link {
        display: inline-block;
        padding: 0.4rem 1rem;
        background: #2c2c2c;
        color: white;
        text-decoration: none;
        font-size: 0.8rem;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }

    .download-link:hover {
        background: #000;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding-top: 1rem;
        border-top: 1px solid #eaeaea;
        font-size: 1.1rem;
    }

    .order-total strong {
        font-size: 1.4rem;
        font-weight: 600;
        color: #111;
    }

    .order-note {
        padding: 1rem 1.5rem;
        background: #f8f8f8;
        border-top: 1px solid #eaeaea;
        font-size: 0.85rem;
        color: #444;
    }

    /* Адаптивность */
    @media (max-width: 640px) {
        .order-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-info {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .ticket-card {
            flex-direction: column;
            align-items: stretch;
        }

        .ticket-action {
            text-align: right;
        }

        .download-link {
            text-align: center;
            display: block;
        }

        .order-total {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }
</style>
@endsection
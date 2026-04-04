<!-- resources/views/front/profile/orders.blade.php -->
@extends('layouts.app')

@section('title', 'Мои билеты')

@section('content')
<div class="container">
    <header class="page-header">
        <h1 class="page-title text-left">Мои билеты</h1>
    </header>
    
    <div class="profile-layout">
        <!-- Боковое меню -->
        <div class="profile-sidebar-wrapper">
            @include('front.profile.partials.sidebar')
        </div>
        
        <!-- Основной контент -->
        <main class="profile-main-content">
            <section class="profile-section card">
                <div class="section-header-padded">
                    <h2 class="section-subtitle-large">История покупок</h2>
                </div>
                
                @if($orders->count() > 0)
                    <div class="order-list-full">
                        @foreach($orders as $order)
                            <div class="order-card-detailed">
                                <div class="order-header-main">
                                    <div class="order-id-info">
                                        <h3 class="order-number-large">Заказ #{{ $order->id }}</h3>
                                        <p class="order-timestamp">
                                            <i class="fas fa-calendar-alt"></i> {{ $order->created_at->format('d.m.Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="order-meta-info">
                                        <div class="order-price-display">
                                            <span class="label">Сумма:</span>
                                            <span class="value">{{ number_format($order->total_amount, 2) }} ₽</span>
                                        </div>
                                        <div class="order-payment-type">
                                            <i class="fas fa-credit-card"></i> 
                                            {{ $order->payment_method == 'online' ? 'Онлайн оплата' : 'Оплата в кассе' }}
                                        </div>
                                        <span class="status-badge status-{{ $order->status }}">
                                            @if($order->status == 'paid') Оплачен
                                            @elseif($order->status == 'pending') Ожидает
                                            @else Отменен @endif
                                        </span>
                                    </div>
                                    <div class="order-header-actions">
                                        <a href="{{ route('profile.order.details', $order->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            Детали заказа
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Мини-список билетов -->
                                <div class="order-tickets-summary">
                                    <h4 class="summary-title">Билеты в заказе ({{ $order->tickets->count() }}):</h4>
                                    <div class="tickets-mini-grid">
                                        @foreach($order->tickets as $ticket)
                                            <div class="ticket-summary-item">
                                                <div class="ticket-spectacle-name">🎭 {{ $ticket->show->spectacle->title }}</div>
                                                <div class="ticket-details-text">
                                                    {{ $ticket->show->start_time->format('d.m.Y H:i') }} | 
                                                    Ряд {{ $ticket->row }}, Место {{ $ticket->seat }}
                                                    @if($ticket->is_used)
                                                        <span class="used-badge">Использован</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="pagination-wrapper mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="empty-state text-center p-5">
                        <i class="fas fa-ticket-alt empty-icon"></i>
                        <p class="empty-text">У вас пока нет заказов. Ваша история покупок будет отображаться здесь.</p>
                        <a href="{{ route('spectacles.index') }}" class="btn btn-primary">
                            Выбрать спектакль
                        </a>
                    </div>
                @endif
            </section>
        </main>
    </div>
</div>

<style>
.profile-layout { display: grid; grid-template-columns: 300px 1fr; gap: 40px; margin-bottom: 60px; }
.section-header-padded { padding: 30px; border-bottom: 1px solid var(--gray-medium); }
.section-subtitle-large { font-size: 1.5rem; color: var(--primary-dark); font-weight: 700; }
.order-list-full { display: flex; flex-direction: column; }
.order-card-detailed { border-bottom: 1px solid var(--gray-medium); padding: 30px; transition: var(--transition); }
.order-card-detailed:last-child { border-bottom: none; }
.order-card-detailed:hover { background-color: var(--gray-light); }
.order-header-main { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; gap: 20px; }
.order-number-large { font-size: 1.3rem; color: var(--primary-dark); margin-bottom: 5px; }
.order-timestamp { font-size: 0.9rem; color: var(--text-muted); }
.order-meta-info { display: flex; flex-direction: column; gap: 8px; }
.order-price-display .label { font-size: 0.9rem; color: var(--text-muted); }
.order-price-display .value { font-size: 1.2rem; font-weight: 800; color: var(--primary-color); margin-left: 5px; }
.order-payment-type { font-size: 0.85rem; color: var(--text-muted); }
.status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-block; width: fit-content; text-align: center; }
.status-paid { background-color: #dcfce7; color: #166534; }
.status-pending { background-color: #fef9c3; color: #854d0e; }
.status-cancelled { background-color: #fee2e2; color: #991b1b; }

.order-tickets-summary { background-color: var(--white); border-radius: 8px; padding: 15px; border: 1px solid var(--border-color); }
.summary-title { font-size: 0.9rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
.tickets-mini-grid { display: grid; grid-template-columns: 1fr; gap: 10px; }
.ticket-summary-item { border-left: 3px solid var(--primary-light); padding-left: 12px; }
.ticket-spectacle-name { font-weight: 600; color: var(--text-color); font-size: 0.95rem; }
.ticket-details-text { font-size: 0.85rem; color: var(--text-muted); margin-top: 2px; }
.used-badge { background-color: var(--gray-medium); color: var(--text-muted); padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; margin-left: 5px; font-weight: 700; }

@media (max-width: 1024px) {
    .profile-layout { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .order-header-main { flex-direction: column; align-items: flex-start; }
    .order-header-actions { width: 100%; }
    .order-header-actions .btn { width: 100%; }
}
</style>
@endsection

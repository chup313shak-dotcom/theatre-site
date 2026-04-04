<!-- resources/views/front/profile/index.blade.php -->
@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container">
    <header class="page-header">
        <h1 class="page-title text-left">Личный кабинет</h1>
    </header>
    
    <div class="profile-layout">
        <!-- Боковое меню -->
        <div class="profile-sidebar-wrapper">
            @include('front.profile.partials.sidebar')
        </div>
        
        <!-- Основной контент -->
        <main class="profile-main-content">
            <!-- Статистика -->
            <section class="stats-grid">
                <div class="stat-card card">
                    <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
                    <div class="stat-info">
                        <h3 class="stat-value">{{ $ordersCount }}</h3>
                        <p class="stat-label">Всего билетов</p>
                    </div>
                </div>
                <div class="stat-card card">
                    <div class="stat-icon icon-heart"><i class="fas fa-heart"></i></div>
                    <div class="stat-info">
                        <h3 class="stat-value">{{ $favoritesCount }}</h3>
                        <p class="stat-label">В избранном</p>
                    </div>
                </div>
                <div class="stat-card card">
                    <div class="stat-icon icon-calendar"><i class="fas fa-calendar-alt"></i></div>
                    <div class="stat-info">
                        <h3 class="stat-value">{{ $recentOrders->count() }}</h3>
                        <p class="stat-label">Последние заказы</p>
                    </div>
                </div>
            </section>
            
            <!-- Последние заказы -->
            <section class="profile-section section">
                <div class="section-header-compact">
                    <h2 class="section-subtitle-large">Последние заказы</h2>
                    <a href="{{ route('profile.orders') }}" class="view-all-link">
                        Все заказы <i class="fas fa-chevron-right" style="font-size: 0.8rem; margin-left: 5px;"></i>
                    </a>
                </div>
                
                @if($recentOrders->count() > 0)
                    <div class="order-list-compact">
                        @foreach($recentOrders as $order)
                            <div class="order-item-card card">
                                <div class="order-info-wrapper">
                                    <div class="order-main-details">
                                        <div class="order-number">Заказ #{{ $order->id }}</div>
                                        <div class="order-date">
                                            <i class="fas fa-clock"></i> {{ $order->created_at->format('d.m.Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="order-amount">
                                        {{ number_format($order->total_amount, 2) }} ₽
                                    </div>
                                    <div class="order-status-wrapper">
                                        <span class="status-badge status-{{ $order->status }}">
                                            @if($order->status == 'paid') Оплачен
                                            @elseif($order->status == 'pending') Ожидает
                                            @else Отменен @endif
                                        </span>
                                    </div>
                                    <div class="order-actions">
                                        <a href="{{ route('profile.order.details', $order->id) }}" 
                                           class="btn btn-outline btn-sm">
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-mini card text-center">
                        <p class="empty-text">У вас пока нет заказов.</p>
                        <a href="{{ route('spectacles.index') }}" class="btn btn-primary btn-sm">
                            Перейти к афише
                        </a>
                    </div>
                @endif
            </section>
        </main>
    </div>
</div>

<style>
.profile-layout { display: grid; grid-template-columns: 300px 1fr; gap: 40px; margin-bottom: 60px; }
.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
.stat-card { padding: 25px; display: flex; align-items: center; gap: 20px; border: none; }
.stat-icon { width: 60px; height: 60px; background-color: var(--primary-light); color: var(--primary-color); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
.stat-icon.icon-heart { background-color: #fff0f0; color: #ff4d4d; }
.stat-icon.icon-calendar { background-color: #f0fdf4; color: #22c55e; }
.stat-value { font-size: 1.8rem; font-weight: 800; color: var(--primary-dark); line-height: 1; }
.stat-label { font-size: 0.9rem; color: var(--text-muted); margin-top: 5px; }

.section-header-compact { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.section-subtitle-large { font-size: 1.5rem; color: var(--primary-dark); font-weight: 700; }
.order-list-compact { display: flex; flex-direction: column; gap: 15px; }
.order-item-card { padding: 20px; border: none; }
.order-info-wrapper { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; align-items: center; gap: 20px; }
.order-number { font-weight: 700; color: var(--primary-dark); font-size: 1.1rem; }
.order-date { font-size: 0.85rem; color: var(--text-muted); margin-top: 5px; }
.order-amount { font-weight: 700; font-size: 1.1rem; color: var(--primary-color); }
.status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-block; }
.status-paid { background-color: #dcfce7; color: #166534; }
.status-pending { background-color: #fef9c3; color: #854d0e; }
.status-cancelled { background-color: #fee2e2; color: #991b1b; }
.btn-sm { padding: 8px 15px; font-size: 0.85rem; }

.empty-state-mini { padding: 40px; border: 2px dashed var(--gray-medium); background: transparent; }

@media (max-width: 1024px) {
    .profile-layout { grid-template-columns: 1fr; }
    .stats-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
}
@media (max-width: 768px) {
    .order-info-wrapper { grid-template-columns: 1fr 1fr; gap: 15px; }
}
</style>
@endsection

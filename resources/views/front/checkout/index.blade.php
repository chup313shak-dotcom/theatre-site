@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Оформление заказа</h1>
        <p class="page-subtitle">Пожалуйста, проверьте данные и выберите способ оплаты</p>
    </div>

    <div class="checkout-grid">
        <!-- Левая колонка: Детали заказа -->
        <div class="checkout-main">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-couch mr-2"></i> Выбранные места</h3>
                </div>
                <div class="card-body">
                    <ul class="checkout-items">
                        @foreach($reservations as $res)
                        <li class="checkout-item">
                            <div class="item-info">
                                <span class="item-seat">Ряд {{ $res->row }}, Место {{ $res->seat }}</span>
                                <span class="item-spectacle">{{ $show->spectacle->title }}</span>
                            </div>
                            <div class="item-price">
                                {{ number_format($res->price, 0, '.', ' ') }} ₽
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="checkout-total">
                        <span>Итого к оплате:</span>
                        <span class="total-amount">{{ number_format($totalAmount, 0, '.', ' ') }} ₽</span>
                    </div>

                    <div class="reservation-timer {{ $isExpired ? 'expired' : '' }}">
                        <i class="fas fa-clock"></i>
                        @if($isExpired)
                            <span>Время резерва истекло. Места могут быть заняты другими.</span>
                        @else
                            <span>Время резерва истекает: <span id="timer">--:--</span></span>
                        @endif
                        
                        <form action="{{ route('order.extend', $order->id) }}" method="POST" class="inline-form ml-auto">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline">
                                <i class="fas fa-plus"></i> Продлить на 30 мин
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-credit-card mr-2"></i> Способ оплаты</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.payment', $order->id) }}" method="POST" id="payment-form">
                        @csrf
                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="online" checked>
                                <div class="method-box">
                                    <i class="fas fa-globe"></i>
                                    <div class="method-text">
                                        <strong>Онлайн оплата</strong>
                                        <p>Банковской картой через платежную систему</p>
                                    </div>
                                    <i class="fas fa-check-circle select-icon"></i>
                                </div>
                            </label>

                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="cash">
                                <div class="method-box">
                                    <i class="fas fa-cash-register"></i>
                                    <div class="method-text">
                                        <strong>Оплата в кассе театра</strong>
                                        <p>Оплатите билеты в кассе до начала спектакля</p>
                                    </div>
                                    <i class="fas fa-check-circle select-icon"></i>
                                </div>
                            </label>
                        </div>

                        <div class="checkout-actions">
                            <a href="{{ route('spectacles.show', $show->spectacle_id) }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> Вернуться к выбору
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock"></i> Оплатить заказ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Правая колонка: Информация о покупателе -->
        <aside class="checkout-sidebar">
            <div class="card sidebar-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user mr-2"></i> Покупатель</h3>
                </div>
                <div class="card-body">
                    <div class="customer-info">
                        <div class="info-group">
                            <label>Имя</label>
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="info-group">
                            <label>Email</label>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                        <div class="info-group">
                            <label>Телефон</label>
                            <p>{{ Auth::user()->phone ?? 'Не указан' }}</p>
                        </div>
                    </div>
                    <div class="info-note">
                        <i class="fas fa-info-circle"></i>
                        Электронные билеты будут отправлены на ваш Email после оплаты.
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
        align-items: start;
    }

    .checkout-items {
        border-bottom: 2px solid var(--gray-medium);
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .checkout-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .item-seat {
        display: block;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .item-spectacle {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .item-price {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .checkout-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-dark);
    }

    .total-amount {
        color: var(--primary-color);
    }

    .reservation-timer {
        margin-top: 25px;
        padding: 15px;
        background-color: var(--primary-light);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: var(--primary-dark);
    }

    .reservation-timer.expired {
        background-color: #ffebee;
        color: #c62828;
    }

    /* Payment Methods */
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 30px;
    }

    .payment-method input {
        display: none;
    }

    .method-box {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        border: 2px solid var(--gray-medium);
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .method-box i:first-child {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    .method-text strong {
        display: block;
        font-size: 1.1rem;
        color: var(--primary-dark);
    }

    .method-text p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    .select-icon {
        margin-left: auto;
        font-size: 1.25rem;
        color: var(--gray-medium);
    }

    .payment-method input:checked + .method-box {
        border-color: var(--primary-color);
        background-color: var(--primary-light);
    }

    .payment-method input:checked + .method-box .select-icon {
        color: var(--primary-color);
    }

    .checkout-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Sidebar info */
    .customer-info .info-group {
        margin-bottom: 15px;
    }

    .customer-info label {
        display: block;
        font-size: 0.8rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .customer-info p {
        font-weight: 600;
        color: var(--primary-dark);
        margin: 0;
    }

    .info-note {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        gap: 10px;
    }

    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@if(!$isExpired)
<script>
    const expirationTime = new Date("{{ $order->payment_expires_at->toIso8601String() }}").getTime();
    
    const timerInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = expirationTime - now;
        
        if (distance < 0) {
            clearInterval(timerInterval);
            document.getElementById("timer").innerHTML = "Время истекло";
            setTimeout(() => {
                location.reload();
            }, 2000);
            return;
        }
        
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("timer").innerHTML = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
    }, 1000);
</script>
@endif
@endsection

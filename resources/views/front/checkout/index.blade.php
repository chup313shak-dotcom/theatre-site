<!-- resources/views/front/checkout/index.blade.php -->
@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Оформление заказа</h1>
        
        @if($isExpired)
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-2xl mr-3"></i>
                        <div>
                            <h3 class="font-bold text-lg">Время резерва истекло</h3>
                            <p class="text-sm">Время бронирования мест истекло.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="extendReservation()" 
                                id="extend-btn"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-plus-circle mr-1"></i> Продлить время
                        </button>
                        <a href="{{ route('spectacles.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-calendar-alt mr-1"></i> Вернуться к афише
                        </a>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Левая колонка - заказ -->
            <div class="md:col-span-2">
                <!-- Выбранные места -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-chair text-red-600 mr-2"></i>
                        Выбранные места
                    </h2>
                    <div class="space-y-2 mb-4">
                        @foreach($reservations as $reservation)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="font-semibold text-lg">Ряд {{ $reservation->row }}, Место {{ $reservation->seat }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $show->spectacle->title }}</span>
                                </div>
                                <div class="text-red-600 font-bold">
                                    {{ number_format($show->getSeatPrice($reservation->row, $reservation->seat), 2) }} ₽
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center text-xl font-bold">
                            <span>Итого:</span>
                            <span class="text-red-600">{{ number_format($totalAmount, 2) }} ₽</span>
                        </div>
                        
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-yellow-600 mr-2"></i>
                                    <span class="text-sm text-yellow-800">Время резерва истекает:</span>
                                    <span id="expiry-timer" class="font-mono font-bold ml-2 text-lg 
                                        @if($isExpired) text-red-600 @else text-green-600 @endif"></span>
                                </div>
                                <button onclick="extendReservation()" 
                                        id="extend-btn"
                                        class="text-sm bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center">
                                    <i class="fas fa-plus-circle mr-1"></i> Продлить на 30 минут
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Способ оплаты -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-credit-card text-red-600 mr-2"></i>
                        Способ оплаты
                    </h2>
                    <form action="{{ route('checkout.payment', $order->id) }}" method="POST" id="payment-form">
                        @csrf
                        <div class="space-y-3 mb-6">
                            <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="payment_method" value="online" class="mr-3 mt-1" checked>
                                <div>
                                    <span class="font-semibold text-lg">💳 Онлайн оплата</span>
                                    <p class="text-sm text-gray-500">Банковской картой через платежную систему</p>
                                </div>
                            </label>
                            <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="payment_method" value="cash" class="mr-3 mt-1">
                                <div>
                                    <span class="font-semibold text-lg">🏦 Оплата в кассе театра</span>
                                    <p class="text-sm text-gray-500">Оплатите билеты в кассе театра до начала спектакля</p>
                                </div>
                            </label>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <a href="{{ route('spectacles.show', $show->spectacle_id) }}" class="text-gray-600 hover:text-gray-800 transition">
                                <i class="fas fa-arrow-left mr-1"></i> Вернуться к спектаклю
                            </a>
                            <button type="submit" id="pay-button" 
                                    class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition flex items-center">
                                <i class="fas fa-credit-card mr-2"></i> Оплатить заказ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Правая колонка - информация -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-user-circle text-red-600 mr-2"></i>
                        Информация о покупателе
                    </h2>
                    <div class="space-y-3">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Покупатель</p>
                            <p class="font-semibold text-lg">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Телефон</p>
                            <p class="font-semibold">{{ Auth::user()->phone ?? 'Не указан' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mr-2 mt-0.5"></i>
                            <p class="text-sm text-blue-800">
                                После оплаты билеты будут доступны для просмотра и отправлены на вашу почту.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-green-50 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-ticket-alt text-green-600 mr-2 mt-0.5"></i>
                            <p class="text-sm text-green-800">
                                Спектакль: <strong>{{ $show->spectacle->title }}</strong><br>
                                Дата: <strong>{{ $show->start_time->format('d.m.Y H:i') }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let expiryTime = null;
let timerElement = document.getElementById('expiry-timer');
let extendBtn = document.getElementById('extend-btn');
let isExpired = {{ $isExpired ? 'true' : 'false' }};

@if($order->payment_expires_at)
    expiryTime = new Date('{{ $order->payment_expires_at }}').getTime();
    
    function updateTimer() {
        const now = new Date().getTime();
        const distance = expiryTime - now;
        
        if (distance <= 0) {
            if (timerElement) {
                timerElement.textContent = 'Время истекло';
                timerElement.classList.add('text-red-600');
                timerElement.classList.remove('text-green-600');
            }
            
            if (extendBtn) {
                extendBtn.disabled = false;
                extendBtn.innerHTML = '<i class="fas fa-plus-circle mr-1"></i> Продлить на 30 минут';
            }
            return;
        }
        
        const minutes = Math.floor(distance / 60000);
        const seconds = Math.floor((distance % 60000) / 1000);
        
        if (timerElement) {
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            timerElement.classList.add('text-green-600');
            timerElement.classList.remove('text-red-600');
            
            if (distance < 300000) {
                timerElement.classList.add('text-red-600');
                timerElement.classList.remove('text-green-600');
            }
        }
    }
    
    function extendReservation() {
        if (extendBtn.disabled) return;
        
        const originalText = extendBtn.innerHTML;
        extendBtn.disabled = true;
        extendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Продление...';
        
        fetch('{{ route("order.extend", $order->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                expiryTime = new Date(data.expires_at).getTime();
                extendBtn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Продлено!';
                setTimeout(() => {
                    extendBtn.innerHTML = originalText;
                    extendBtn.disabled = false;
                }, 2000);
                
                // Обновляем страницу, чтобы показать новое время
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                alert('Ошибка при продлении времени');
                extendBtn.innerHTML = originalText;
                extendBtn.disabled = false;
            }
        })
        .catch(error => {
            alert('Ошибка соединения');
            extendBtn.innerHTML = originalText;
            extendBtn.disabled = false;
        });
    }
    
    setInterval(updateTimer, 1000);
    updateTimer();
    
    // Обработка отправки формы
    document.getElementById('payment-form')?.addEventListener('submit', function(e) {
        const button = document.getElementById('pay-button');
        if (button) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Обработка оплаты...';
        }
    });
@endif
</script>
@endpush
@endsection
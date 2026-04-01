<!-- resources/views/front/spectacles/show.blade.php -->
@extends('layouts.app')

@section('title', $spectacle->title)

@section('content')
<div class="container mx-auto px-4">
    <!-- Спектакль -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6">
                <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                     alt="{{ $spectacle->title }}"
                     class="w-full rounded-lg shadow-lg">
            </div>
            
            <div class="md:col-span-2 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-3xl font-bold">{{ $spectacle->title }}</h1>
                    @auth
                        @php
                            $isFavorite = Auth::user()->isFavorite($spectacle->id);
                        @endphp
                        <button onclick="toggleFavorite({{ $spectacle->id }})"
                                class="text-2xl {{ $isFavorite ? 'text-red-600' : 'text-gray-400' }} hover:text-red-600 transition">
                            <i class="fas fa-heart"></i>
                        </button>
                    @endauth
                </div>
                
                <div class="flex items-center mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($spectacle->rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                    <span class="ml-2 text-gray-600">{{ number_format($spectacle->rating, 1) }} ({{ $spectacle->reviews_count }} отзывов)</span>
                </div>
                
                <div class="space-y-2 mb-6">
                    <p><strong>Режиссер:</strong> {{ $spectacle->director }}</p>
                    <p><strong>Продолжительность:</strong> {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин</p>
                    <p><strong>Жанр:</strong> {{ $spectacle->genre }}</p>
                    <p><strong>Возрастное ограничение:</strong> {{ $spectacle->age_limit }}</p>
                </div>
                
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Описание</h3>
                    <p class="text-gray-700">{{ $spectacle->description }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Выбор даты и времени -->
    @if($spectacle->shows->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">Выберите дату и время</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                @foreach($spectacle->shows as $show)
                    <button onclick="selectShow({{ $show->id }})" 
                            class="show-date-btn p-3 border rounded-lg text-center hover:border-red-500 transition"
                            data-show-id="{{ $show->id }}"
                            data-date="{{ $show->start_time->format('d.m.Y H:i') }}">
                        <div class="font-bold">{{ $show->start_time->format('d.m') }}</div>
                        <div class="text-sm text-gray-600">{{ $show->start_time->format('H:i') }}</div>
                    </button>
                @endforeach
            </div>
            
            <!-- Схема зала -->
            <div id="hall-schema-container" class="mt-6">
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-calendar-alt text-4xl mb-2"></i>
                    <p>Выберите дату спектакля для просмотра схемы зала</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center mb-8">
            <i class="fas fa-calendar-times text-3xl text-yellow-600 mb-2"></i>
            <p class="text-yellow-800">Ближайших показов нет. Следите за афишей!</p>
        </div>
    @endif
    
    <!-- Актерский состав -->
    @if($spectacle->actors->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">Актерский состав</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($spectacle->actors as $actor)
                    <a href="{{ route('actors.show', $actor->id) }}" class="text-center group">
                        <div class="w-24 h-24 mx-auto bg-gray-200 rounded-full overflow-hidden mb-2">
                            @if($actor->photo)
                                <img src="{{ $actor->photo }}" alt="{{ $actor->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-user text-3xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <p class="font-semibold group-hover:text-red-600">{{ $actor->name }}</p>
                        @if($actor->pivot->role)
                            <p class="text-xs text-gray-500">{{ $actor->pivot->role }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Отзывы -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Отзывы зрителей</h2>
        
        @auth
            <form action="{{ route('spectacles.review', $spectacle->id) }}" method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-2">Ваша оценка</label>
                    <div class="flex space-x-2 rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-2xl cursor-pointer text-gray-300 hover:text-yellow-400 transition" data-rating="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="">
                </div>
                <div class="mb-3">
                    <textarea name="comment" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                              placeholder="Поделитесь впечатлениями о спектакле..."></textarea>
                </div>
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                    Оставить отзыв
                </button>
            </form>
        @else
            <p class="text-gray-500 mb-4">Чтобы оставить отзыв, <a href="{{ route('login') }}" class="text-red-600 hover:underline">войдите</a> в свой аккаунт.</p>
        @endauth
        
        @if($spectacle->reviews->count() > 0)
            <div class="space-y-4">
                @foreach($spectacle->reviews as $review)
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="font-semibold">{{ $review->author_name }}</span>
                                <div class="flex mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $review->created_at->format('d.m.Y') }}</span>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-6">Пока нет отзывов. Будьте первым!</p>
        @endif
    </div>
</div>

@push('scripts')
<script>
let selectedShowId = null;

function selectShow(showId) {
    selectedShowId = showId;
    
    // Подсветка выбранной даты
    document.querySelectorAll('.show-date-btn').forEach(btn => {
        btn.classList.remove('border-red-500', 'bg-red-50');
        if(btn.dataset.showId == showId) {
            btn.classList.add('border-red-500', 'bg-red-50');
        }
    });
    
    // Загрузка схемы зала
    loadHallSchema(showId);
}

function loadHallSchema(showId) {
    const container = document.getElementById('hall-schema-container');
    container.innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl"></i><p class="mt-2">Загрузка схемы зала...</p></div>';
    
    fetch(`/api/shows/${showId}/seats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderHallSchema(data);
            } else {
                container.innerHTML = '<div class="text-center text-red-500 py-8">Ошибка загрузки схемы зала</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = '<div class="text-center text-red-500 py-8">Ошибка загрузки схемы зала</div>';
        });
}

function renderHallSchema(data) {
    const container = document.getElementById('hall-schema-container');
    
    let html = `
        <div class="hall-schema-container">
            <div class="text-center mb-6">
                <h3 class="text-xl font-bold">Схема зала</h3>
                <p class="text-gray-600">Спектакль: ${data.spectacle_title} | ${data.start_time}</p>
                <p class="text-sm text-gray-500">Выберите места (доступны только свободные места)</p>
            </div>
            
            <!-- Сцена -->
            <div class="stage text-center mb-8">
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-3 rounded-lg w-3/4 mx-auto shadow-lg">
                    <i class="fas fa-microphone-alt mr-2"></i>СЦЕНА
                </div>
            </div>
            
            <!-- Зрительный зал -->
            <div class="hall flex flex-col items-center space-y-2 overflow-x-auto pb-4">
    `;
    
    data.hall_schema.rows.forEach(row => {
        html += `
            <div class="flex justify-center items-center space-x-2 min-w-max">
                <div class="w-12 text-right font-bold text-gray-700">${row.row}</div>
                <div class="flex space-x-1">
        `;
        
        row.seats.forEach(seat => {
            let statusClass = '';
            let disabled = '';
            
            if (seat.status === 'available') {
                statusClass = 'bg-blue-500 hover:bg-blue-600 hover:shadow-md';
                disabled = '';
            } else if (seat.status === 'selected') {
                statusClass = 'bg-green-500 hover:bg-green-600 shadow-lg';
                disabled = '';
            } else {
                statusClass = 'bg-gray-300 cursor-not-allowed opacity-50';
                disabled = 'disabled';
            }
            
            html += `
                <button 
                    onclick="toggleSeat('${row.row}', ${seat.number})"
                    class="seat-btn w-10 h-10 rounded-lg text-white font-bold transition-all duration-200 text-sm ${statusClass}"
                    data-row="${row.row}"
                    data-seat="${seat.number}"
                    data-status="${seat.status}"
                    ${disabled}
                >
                    ${seat.number}
                </button>
            `;
        });
        
        html += `
                </div>
            </div>
        `;
    });
    
    html += `
            </div>
            
            <!-- Легенда -->
            <div class="legend flex justify-center space-x-6 mt-8 py-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-blue-500 rounded mr-2"></div>
                    <span class="text-sm">Свободно</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-green-500 rounded mr-2"></div>
                    <span class="text-sm">Выбрано</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-gray-300 rounded mr-2"></div>
                    <span class="text-sm">Занято</span>
                </div>
            </div>
            
            <!-- Выбранные места -->
            <div id="selected-seats-info" class="mt-6 hidden">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="font-bold text-gray-800 mb-3">Выбранные места:</h4>
                    <div id="selected-seats-list" class="flex flex-wrap gap-2 mb-4"></div>
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-clock mr-1"></i>
                            Время резерва: <span id="timer">10:00</span>
                        </div>
                        <button onclick="confirmSelection()" 
                                class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors shadow-md">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Подтвердить выбор (<span id="selected-count">0</span>)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
    
    // Сохраняем данные в глобальные переменные
    window.currentShowId = data.show_id;
    window.prices = data.prices;
    window.reservationTimeout = data.reservation_timeout;
    window.selectedSeats = [];
    
    startTimer();
}

let selectedSeats = [];
let timerInterval = null;
let timeLeft = 600;

function toggleSeat(row, seat) {
    const btn = document.querySelector(`.seat-btn[data-row="${row}"][data-seat="${seat}"]`);
    
    if (btn.disabled) return;
    
    const index = selectedSeats.findIndex(s => s.row === row && s.seat === seat);
    
    if (index === -1) {
        // Добавляем место
        selectedSeats.push({ row, seat });
        btn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
        btn.classList.add('bg-green-500', 'hover:bg-green-600');
        btn.dataset.status = 'selected';
    } else {
        // Удаляем место
        selectedSeats.splice(index, 1);
        btn.classList.remove('bg-green-500', 'hover:bg-green-600');
        btn.classList.add('bg-blue-500', 'hover:bg-blue-600');
        btn.dataset.status = 'available';
    }
    
    updateSelectedSeatsDisplay();
}

function updateSelectedSeatsDisplay() {
    const infoDiv = document.getElementById('selected-seats-info');
    const listDiv = document.getElementById('selected-seats-list');
    const countSpan = document.getElementById('selected-count');
    
    if (selectedSeats.length > 0) {
        infoDiv.classList.remove('hidden');
        
        let html = '';
        selectedSeats.forEach(seat => {
            html += `
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm flex items-center">
                    <i class="fas fa-chair mr-1"></i>
                    ${seat.row}${seat.seat}
                    <button onclick="removeSeat('${seat.row}', ${seat.seat})" class="ml-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </span>
            `;
        });
        listDiv.innerHTML = html;
        countSpan.textContent = selectedSeats.length;
    } else {
        infoDiv.classList.add('hidden');
    }
}

function removeSeat(row, seat) {
    const index = selectedSeats.findIndex(s => s.row === row && s.seat === seat);
    if (index !== -1) {
        selectedSeats.splice(index, 1);
        
        const btn = document.querySelector(`.seat-btn[data-row="${row}"][data-seat="${seat}"]`);
        if (btn) {
            btn.classList.remove('bg-green-500', 'hover:bg-green-600');
            btn.classList.add('bg-blue-500', 'hover:bg-blue-600');
            btn.dataset.status = 'available';
        }
        
        updateSelectedSeatsDisplay();
    }
}

function startTimer() {
    timeLeft = window.reservationTimeout || 600;
    
    if (timerInterval) clearInterval(timerInterval);
    
    timerInterval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('timer').textContent = '0:00';
            alert('Время выбора мест истекло. Пожалуйста, обновите страницу.');
        } else {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
    }, 1000);
}

function confirmSelection() {
    if (selectedSeats.length === 0) {
        alert('Выберите места');
        return;
    }
    
    @auth
        if (!confirm(`Вы выбрали ${selectedSeats.length} мест(а). Продолжить?`)) return;
        
        fetch(`/api/shows/${window.currentShowId}/reserve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ seats: selectedSeats })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                alert(data.error || 'Ошибка при резервировании мест');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка соединения. Попробуйте позже.');
        });
    @else
        alert('Для покупки билетов необходимо войти в систему');
        window.location.href = '{{ route("login") }}';
    @endauth
}

function toggleFavorite(spectacleId) {
    fetch(`/profile/favorites/${spectacleId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Обработка рейтинга
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars i');
    const ratingInput = document.getElementById('rating-value');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
});
</script>
@endpush
@endsection
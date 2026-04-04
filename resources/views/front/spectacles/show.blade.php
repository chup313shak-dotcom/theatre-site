<!-- resources/views/front/spectacles/show.blade.php -->
@extends('layouts.app')

@section('title', $spectacle->title)

@section('content')
<div class="container">
    <!-- Спектакль -->
    <div class="detail-container card">
        <div class="detail-content-wrapper">
            <div class="detail-image-box">
                <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                     alt="{{ $spectacle->title }}"
                     class="detail-image">
            </div>
            
            <div class="detail-content">
                <div class="detail-header">
                    <h1 class="page-title text-left">{{ $spectacle->title }}</h1>
                    @auth
                        @php
                            $isFavorite = Auth::user()->isFavorite($spectacle->id);
                        @endphp
                        <button onclick="toggleFavorite({{ $spectacle->id }})"
                                class="favorite-btn {{ $isFavorite ? 'active' : '' }}">
                            <i class="fas fa-heart"></i>
                        </button>
                    @endauth
                </div>
                
                <div class="rating-display">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($spectacle->rating) ? 'star-active' : 'star-inactive' }}"></i>
                    @endfor
                    <span class="rating-count">{{ number_format($spectacle->rating, 1) }} ({{ $spectacle->reviews_count }} отзывов)</span>
                </div>
                
                <div class="spectacle-info-grid">
                    <p><strong>Режиссер:</strong> {{ $spectacle->director }}</p>
                    <p><strong>Продолжительность:</strong> {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин</p>
                    <p><strong>Жанр:</strong> {{ $spectacle->genre }}</p>
                    <p><strong>Возрастное ограничение:</strong> {{ $spectacle->age_limit }}</p>
                </div>
                
                <div class="spectacle-description">
                    <h3 class="section-subtitle">Описание</h3>
                    <p class="description-text">{{ $spectacle->description }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Выбор даты и времени -->
    @if($spectacle->shows->count() > 0)
        <div class="shows-selection section">
            <h2 class="section-title">Выберите дату и время</h2>
            <div class="shows-grid-compact">
                @foreach($spectacle->shows as $show)
                    <button onclick="selectShow({{ $show->id }})" 
                            class="show-date-btn"
                            data-show-id="{{ $show->id }}"
                            data-date="{{ $show->start_time->format('d.m.Y H:i') }}">
                        <div class="show-day">{{ $show->start_time->format('d.m') }}</div>
                        <div class="show-time">{{ $show->start_time->format('H:i') }}</div>
                    </button>
                @endforeach
            </div>
            
            <!-- Схема зала -->
            <div id="hall-schema-container" class="hall-schema-wrapper">
                <div class="empty-state text-center">
                    <i class="fas fa-calendar-alt empty-icon"></i>
                    <p class="empty-text">Выберите дату спектакля для просмотра схемы зала</p>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state text-center">
            <i class="fas fa-calendar-times empty-icon"></i>
            <p class="empty-text">Ближайших показов нет. Следите за афишей!</p>
        </div>
    @endif
    
    <!-- Актерский состав -->
    @if($spectacle->actors->count() > 0)
        <div class="actors-section section">
            <h2 class="section-title">Актерский состав</h2>
            <div class="card-grid">
                @foreach($spectacle->actors as $actor)
                    <a href="{{ route('actors.show', $actor->id) }}" class="card actor-card-compact">
                        <div class="card-image-wrapper">
                            @if($actor->photo)
                                <img src="{{ $actor->photo }}" alt="{{ $actor->name }}" class="card-image">
                            @else
                                <div class="actor-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h4 class="actor-name">{{ $actor->name }}</h4>
                            @if($actor->pivot->role)
                                <p class="actor-role">{{ $actor->pivot->role }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Отзывы -->
    <div class="reviews-section section">
        <h2 class="section-title">Отзывы зрителей</h2>
        
        @auth
            <div class="review-form-container card">
                <form action="{{ route('spectacles.review', $spectacle->id) }}" method="POST" class="review-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Ваша оценка</label>
                        <div class="rating-stars-input">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-rating="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value="">
                    </div>
                    <div class="form-group">
                        <textarea name="comment" rows="3" class="form-control" 
                                  placeholder="Поделитесь впечатлениями о спектакле..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Оставить отзыв
                    </button>
                </form>
            </div>
        @else
            <div class="auth-prompt text-center">
                <p>Чтобы оставить отзыв, <a href="{{ route('login') }}" class="text-link">войдите</a> в свой аккаунт.</p>
            </div>
        @endauth
        
        @if($spectacle->reviews->count() > 0)
            <div class="reviews-list">
                @foreach($spectacle->reviews as $review)
                    <div class="review-item card">
                        <div class="review-header">
                            <div class="author-info">
                                <span class="author-name">{{ $review->author_name }}</span>
                                <div class="author-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'star-active' : 'star-inactive' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="review-date">{{ $review->created_at->format('d.m.Y') }}</span>
                        </div>
                        <p class="review-comment">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state text-center">
                <p class="empty-text">Пока нет отзывов. Будьте первым!</p>
            </div>
        @endif
    </div>
</div>

<style>
.detail-container { margin-bottom: 50px; padding: 0; overflow: hidden; }
.detail-content-wrapper { display: flex; flex-direction: row; }
.detail-image-box { width: 40%; flex-shrink: 0; }
.detail-image { width: 100%; height: 100%; object-fit: cover; }
.detail-content { padding: 40px; flex: 1; }
.detail-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
.favorite-btn { background: none; border: none; font-size: 1.5rem; color: var(--gray-medium); cursor: pointer; transition: var(--transition); }
.favorite-btn.active { color: var(--primary-color); }
.rating-display { display: flex; align-items: center; gap: 10px; margin-bottom: 25px; }
.star-active { color: #ffc107; }
.star-inactive { color: var(--gray-medium); }
.rating-count { color: var(--text-muted); font-size: 0.95rem; }
.spectacle-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; padding: 20px; background-color: var(--gray-light); border-radius: 8px; }
.section-subtitle { font-size: 1.25rem; color: var(--primary-dark); margin-bottom: 15px; border-bottom: 2px solid var(--primary-light); padding-bottom: 5px; }
.description-text { color: var(--text-color); line-height: 1.8; }
.shows-grid-compact { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 30px; }
.show-date-btn { padding: 15px 25px; border: 2px solid var(--border-color); border-radius: 12px; background: var(--white); cursor: pointer; transition: var(--transition); text-align: center; }
.show-date-btn:hover { border-color: var(--primary-color); background-color: var(--primary-light); }
.show-date-btn.active { border-color: var(--primary-color); background-color: var(--primary-color); color: var(--white); }
.show-day { font-size: 1.1rem; font-weight: 700; }
.show-time { font-size: 0.9rem; opacity: 0.9; }
.hall-schema-wrapper { background-color: var(--gray-light); border-radius: 15px; padding: 40px; min-height: 300px; }
.review-form-container { padding: 30px; margin-bottom: 40px; }
.rating-stars-input { font-size: 1.5rem; color: var(--gray-medium); cursor: pointer; margin-bottom: 10px; }
.rating-stars-input i:hover, .rating-stars-input i.active { color: #ffc107; }
.reviews-list { display: flex; flex-direction: column; gap: 20px; }
.review-item { padding: 25px; }
.review-header { display: flex; justify-content: space-between; margin-bottom: 15px; }
.author-name { font-weight: 700; color: var(--primary-dark); display: block; }
.review-date { color: var(--text-muted); font-size: 0.85rem; }
.review-comment { color: var(--text-color); font-style: italic; }
.text-link { color: var(--primary-color); font-weight: 600; text-decoration: underline; }

@media (max-width: 768px) {
    .detail-content-wrapper { flex-direction: column; }
    .detail-image-box { width: 100%; height: 350px; }
    .spectacle-info-grid { grid-template-columns: 1fr; }
}

/* Hall Schema Custom Styles */
.hall-schema-container { max-width: 800px; margin: 0 auto; }
.stage { background-color: var(--primary-dark); color: var(--white); padding: 15px; border-radius: 4px 4px 40px 40px; margin-bottom: 50px; font-weight: 700; letter-spacing: 5px; }
.hall-row { display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 10px; }
.row-number { width: 30px; font-weight: 700; color: var(--text-muted); }
.seats-container { display: flex; gap: 8px; }
.seat-btn { width: 35px; height: 35px; border-radius: 6px; border: none; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600; color: var(--white); cursor: pointer; transition: var(--transition); }
.seat-btn.available { background-color: var(--primary-color); }
.seat-btn.available:hover { transform: scale(1.1); box-shadow: var(--shadow); }
.seat-btn.selected { background-color: var(--success-color); animation: pulse 1.5s infinite; }
.seat-btn.reserved { background-color: var(--gray-medium); color: var(--text-muted); cursor: not-allowed; }
.legend { display: flex; justify-content: center; gap: 25px; margin: 40px 0; padding: 20px; border-top: 1px solid var(--border-color); }
.legend-item { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; }
.legend-color { width: 20px; height: 20px; border-radius: 4px; }
.selection-summary { margin-top: 30px; padding: 25px; background-color: var(--primary-light); border-radius: 12px; display: flex; justify-content: space-between; align-items: center; }
.selected-seats-list { display: flex; flex-wrap: wrap; gap: 10px; margin: 10px 0; }
.seat-tag { padding: 5px 12px; background-color: var(--white); border: 1px solid var(--primary-color); color: var(--primary-color); border-radius: 20px; font-size: 0.85rem; font-weight: 700; }
@keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.7; } 100% { opacity: 1; } }
</style>

@push('scripts')
<script>
let selectedShowId = null;

function selectShow(showId) {
    selectedShowId = showId;
    
    // Подсветка выбранной даты
    document.querySelectorAll('.show-date-btn').forEach(btn => {
        btn.classList.remove('active');
        if(btn.dataset.showId == showId) {
            btn.classList.add('active');
        }
    });
    
    // Загрузка схемы зала
    loadHallSchema(showId);
}

function loadHallSchema(showId) {
    const container = document.getElementById('hall-schema-container');
    container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i><p class="mt-4">Загрузка схемы зала...</p></div>';
    
    fetch(`/api/shows/${showId}/seats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderHallSchema(data);
            } else {
                container.innerHTML = '<div class="text-center">Ошибка загрузки схемы зала</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = '<div class="text-center">Ошибка загрузки схемы зала</div>';
        });
}

function renderHallSchema(data) {
    const container = document.getElementById('hall-schema-container');
    
    let html = `
        <div class="hall-schema-container">
            <div class="text-center mb-4">
                <h3 class="section-subtitle">Схема зала</h3>
                <p class="text-muted">Спектакль: ${data.spectacle_title} | ${data.start_time}</p>
                <p class="small">Выберите места (доступны только свободные места)</p>
            </div>
            
            <!-- Сцена -->
            <div class="stage text-center">
                СЦЕНА
            </div>
            
            <!-- Зрительный зал -->
            <div class="hall">
    `;
    
    data.hall_schema.rows.forEach(row => {
        html += `
            <div class="hall-row">
                <div class="row-number">${row.row}</div>
                <div class="seats-container">
        `;
        
        row.seats.forEach(seat => {
            let statusClass = '';
            let disabled = '';
            
            if (seat.status === 'available') {
                statusClass = 'available';
                disabled = '';
            } else if (seat.status === 'selected') {
                statusClass = 'selected';
                disabled = '';
            } else {
                statusClass = 'reserved';
                disabled = 'disabled';
            }
            
            html += `
                <button 
                    onclick="toggleSeat('${row.row}', ${seat.number})"
                    class="seat-btn ${statusClass}"
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
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--primary-color);"></div>
                    <span>Свободно</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--success-color);"></div>
                    <span>Выбрано</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--gray-medium);"></div>
                    <span>Занято</span>
                </div>
            </div>
            
            <!-- Выбранные места -->
            <div id="selected-seats-info" class="selection-summary hidden">
                <div class="selection-details">
                    <h4 class="small-title">Выбранные места:</h4>
                    <div id="selected-seats-list" class="selected-seats-list"></div>
                    <div class="timer-box">
                        <i class="fas fa-clock"></i>
                        Время резерва: <span id="timer">10:00</span>
                    </div>
                </div>
                <button onclick="confirmSelection()" class="btn btn-primary">
                    <i class="fas fa-ticket-alt"></i>
                    Купить билеты (<span id="selected-count">0</span>)
                </button>
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
        btn.classList.remove('available');
        btn.classList.add('selected');
        btn.dataset.status = 'selected';
    } else {
        // Удаляем место
        selectedSeats.splice(index, 1);
        btn.classList.remove('selected');
        btn.classList.add('available');
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
                <span class="seat-tag">
                    ${seat.row} ряд, ${seat.seat} место
                    <i class="fas fa-times" onclick="removeSeat('${seat.row}', ${seat.seat})" style="margin-left: 8px; cursor: pointer;"></i>
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
            btn.classList.remove('selected');
            btn.classList.add('available');
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
        if (!confirm(`Вы выбрали ${selectedSeats.length} мест(а). Продолжить оформление заказа?`)) return;
        
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
            const btn = document.querySelector('.favorite-btn');
            btn.classList.toggle('active');
        }
    });
}

// Обработка рейтинга
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars-input i');
    const ratingInput = document.getElementById('rating-value');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
        
        star.addEventListener('mouseover', function() {
            const rating = this.dataset.rating;
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#ffc107';
                }
            });
        });
        
        star.addEventListener('mouseout', function() {
            stars.forEach(s => {
                if (!s.classList.contains('active')) {
                    s.style.color = '';
                }
            });
        });
    });
});
</script>
@endpush
@endsection

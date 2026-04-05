<!-- resources/views/front/spectacles/show.blade.php -->
@extends('layouts.app')

@section('title', $spectacle->title)

@section('content')
<div class="container py-10">
    <!-- Спектакль -->
    <div class="spectacle-detail-card card overflow-hidden mb-16">
        <div class="spectacle-flex-wrapper">
            <!-- Постер -->
            <div class="spectacle-poster-side">
                <img src="{{ asset($spectacle->poster ?? 'images/posters/default.jpg') }}" 
                     alt="{{ $spectacle->title }}"
                     class="spectacle-main-img">
                <div class="age-badge-large">{{ $spectacle->age_limit }}</div>
            </div>
            
            <!-- Информация -->
            <div class="spectacle-info-side p-10">
                <div class="spectacle-header mb-6">
                    <h1 class="spectacle-title-main mb-4">{{ $spectacle->title }}</h1>
                    
                    <div class="rating-box-inline">
                        <div class="stars-gold">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($spectacle->rating) ? 'active' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="rating-text-lg">{{ number_format($spectacle->rating, 1) }}</span>
                        <span class="reviews-count-lg">({{ $spectacle->reviews_count }} отзывов)</span>
                    </div>
                </div>
                
                <!-- Характеристики в виде плиток -->
                <div class="spectacle-stats-grid mb-10">
                    <div class="stat-item-box">
                        <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="stat-content">
                            <span class="stat-label">Режиссер</span>
                            <span class="stat-value">{{ $spectacle->director }}</span>
                        </div>
                    </div>
                    <div class="stat-item-box">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-content">
                            <span class="stat-label">Продолжительность</span>
                            <span class="stat-value">{{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин</span>
                        </div>
                    </div>
                    <div class="stat-item-box">
                        <div class="stat-icon"><i class="fas fa-masks-theater"></i></div>
                        <div class="stat-content">
                            <span class="stat-label">Жанр</span>
                            <span class="stat-value">{{ $spectacle->genre }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="description-section">
                    <h3 class="section-subtitle-decorated mb-4">Описание</h3>
                    <div class="description-text-large">
                        {{ $spectacle->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Выбор даты и времени -->
    @if($spectacle->shows->count() > 0)
        <section class="section mb-16">
            <div class="section-header mb-8">
                <h2 class="section-title">Выберите дату и время</h2>
            </div>
            
            <div class="shows-selection-container">
                <div class="shows-scroll-wrapper">
                    @foreach($spectacle->shows as $show)
                        <button onclick="selectShow({{ $show->id }})" 
                                class="show-card-btn"
                                data-show-id="{{ $show->id }}">
                            <div class="show-date-day">{{ $show->start_time->format('d') }}</div>
                            <div class="show-date-month">{{ $show->start_time->translatedFormat('M') }}</div>
                            <div class="show-date-time">{{ $show->start_time->format('H:i') }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
            
            <!-- Схема зала (появится после выбора даты) -->
            <div id="hall-schema-container" class="hall-schema-outer mt-10">
                <div class="empty-state-schema text-center p-12">
                    <div class="icon-circle mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <p class="empty-text">Выберите удобную дату выше, чтобы открыть схему зала и купить билеты</p>
                </div>
            </div>
        </section>
    @else
        <div class="card p-12 text-center mb-16">
            <i class="fas fa-calendar-xmark fa-4x mb-4 text-muted"></i>
            <h3 class="text-xl font-bold">Ближайших показов нет</h3>
            <p class="text-muted">Подпишитесь на наши новости, чтобы не пропустить возвращение спектакля на сцену!</p>
        </div>
    @endif
    
    <!-- Актерский состав -->
    @if($spectacle->actors->count() > 0)
        <section class="section mb-16">
            <div class="section-header mb-8">
                <h2 class="section-title">Актерский состав</h2>
            </div>
            <div class="card-grid">
                @foreach($spectacle->actors as $actor)
                    <a href="{{ route('actors.show', $actor->id) }}" class="card actor-card-hover">
                        <div class="card-image-wrapper aspect-square">
                            @if($actor->photo)
                                <img src="{{ asset($actor->photo) }}" alt="{{ $actor->name }}" class="card-image">
                            @else
                                <div class="bg-gray-medium h-full flex items-center justify-center text-white">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h4 class="actor-name-sm">{{ $actor->name }}</h4>
                            @if($actor->pivot->role)
                                <span class="actor-role-tag">{{ $actor->pivot->role }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
    
    <!-- Отзывы -->
    <section class="reviews-section section">
        <div class="section-header mb-8">
            <h2 class="section-title">Отзывы зрителей</h2>
        </div>
        
        <div class="reviews-layout">
            <div class="reviews-form-column">
                @auth
                    <div class="card p-8 sticky-form">
                        <h3 class="text-lg font-bold mb-6">Оставить отзыв</h3>
                        <form action="{{ route('spectacles.review', $spectacle->id) }}" method="POST" class="review-form-styled">
                            @csrf
                            <div class="form-group mb-6">
                                <label class="form-label">Ваша оценка</label>
                                <div class="rating-stars-input-large">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" />
                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label">Комментарий</label>
                                <textarea name="comment" rows="4" class="form-control" 
                                          placeholder="Поделитесь вашими впечатлениями..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-full">
                                Опубликовать отзыв
                            </button>
                        </form>
                    </div>
                @else
                    <div class="card p-8 bg-primary-light border-none text-center">
                        <i class="fas fa-user-lock fa-3x mb-4 text-primary"></i>
                        <p class="mb-4">Только зарегистрированные пользователи могут оставлять отзывы.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline">Войти в аккаунт</a>
                    </div>
                @endauth
            </div>
            
            <div class="reviews-list-column">
                @if($spectacle->reviews->count() > 0)
                    <div class="reviews-stack">
                        @foreach($spectacle->reviews as $review)
                            <div class="card p-6 mb-4 review-card">
                                <div class="review-header-flex">
                                    <div class="user-info">
                                        <div class="user-avatar-placeholder">
                                            {{ mb_substr($review->author_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="review-user-name">{{ $review->author_name }}</h4>
                                            <div class="stars-gold-sm">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="review-date-tag">{{ $review->created_at->format('d.m.Y') }}</span>
                                </div>
                                <div class="review-body-text">
                                    "{{ $review->comment }}"
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-reviews card p-10 text-center">
                        <p class="text-muted italic">Пока никто не оставил отзыв. Станьте первым!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mb-10 { margin-bottom: 2.5rem; }
    .mb-16 { margin-bottom: 4rem; }
    .p-10 { padding: 2.5rem; }
    .mt-10 { margin-top: 2.5rem; }
    .w-full { width: 100%; }

    /* Spectacle Card Layout */
    .spectacle-flex-wrapper { display: flex; min-height: 650px; }
    .spectacle-poster-side { width: 35%; flex-shrink: 0; position: relative; background-color: var(--primary-dark); }
    .spectacle-main-img { width: 100%; height: 100%; object-fit: cover; }
    .age-badge-large { position: absolute; top: 30px; right: 30px; width: 60px; height: 60px; background-color: rgba(0,0,0,0.6); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; border: 2px solid rgba(255,255,255,0.3); backdrop-filter: blur(5px); }

    .spectacle-info-side { flex: 1; background-color: var(--white); }
    .spectacle-title-main { font-size: 3.5rem; font-weight: 900; color: var(--primary-dark); line-height: 1; letter-spacing: -1px; }
    
    .rating-box-inline { display: flex; align-items: center; gap: 12px; }
    .stars-gold { color: #ffc107; font-size: 1.2rem; }
    .stars-gold i { margin-right: 2px; }
    .stars-gold i:not(.active) { color: var(--gray-medium); }
    .rating-text-lg { font-size: 1.5rem; font-weight: 800; color: var(--primary-dark); }
    .reviews-count-lg { color: var(--text-muted); }

    /* Stats Grid */
    .spectacle-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
    .stat-item-box { display: flex; align-items: center; gap: 15px; padding: 15px; background-color: var(--gray-light); border-radius: 12px; transition: var(--transition); }
    .stat-item-box:hover { background-color: var(--primary-light); transform: translateY(-3px); }
    .stat-icon { width: 45px; height: 45px; background-color: var(--white); color: var(--primary-color); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .stat-content { display: flex; flex-direction: column; }
    .stat-label { font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.5px; }
    .stat-value { font-weight: 700; color: var(--primary-dark); font-size: 1rem; }

    .section-subtitle-decorated { font-size: 1.5rem; color: var(--primary-dark); font-weight: 700; position: relative; padding-bottom: 10px; border-bottom: 3px solid var(--accent-color); display: inline-block; }
    .description-text-large { font-size: 1.15rem; line-height: 1.8; color: var(--text-color); }

    /* Show Dates */
    .shows-scroll-wrapper { display: flex; gap: 15px; overflow-x: auto; padding-bottom: 15px; }
    .show-card-btn { flex: 0 0 100px; height: 120px; background-color: var(--white); border: 2px solid var(--border-color); border-radius: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition); }
    .show-card-btn:hover { border-color: var(--primary-color); background-color: var(--primary-light); }
    .show-card-btn.active { background-color: var(--primary-color); border-color: var(--primary-color); color: var(--white); box-shadow: 0 10px 20px rgba(0, 71, 171, 0.3); }
    .show-date-day { font-size: 1.8rem; font-weight: 900; line-height: 1; }
    .show-date-month { font-size: 0.8rem; text-transform: uppercase; font-weight: 700; margin-bottom: 5px; }
    .show-date-time { font-size: 0.9rem; font-weight: 600; opacity: 0.8; }

    .hall-schema-outer { background-color: var(--gray-light); border-radius: 24px; min-height: 400px; padding: 40px; }
    .icon-circle { width: 80px; height: 80px; background-color: var(--white); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 2rem; color: var(--primary-color); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }

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

    /* Actors */
    .actor-card-hover { transition: var(--transition); }
    .actor-card-hover:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .actor-name-sm { font-weight: 700; color: var(--primary-dark); margin-bottom: 5px; }
    .actor-role-tag { font-size: 0.8rem; color: var(--primary-color); font-weight: 600; background-color: var(--primary-light); padding: 3px 10px; border-radius: 4px; }

    /* Reviews */
    .reviews-layout { display: grid; grid-template-columns: 350px 1fr; gap: 40px; }
    .sticky-form { position: sticky; top: 100px; }
    .rating-stars-input-large { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px; }
    .rating-stars-input-large input { display: none; }
    .rating-stars-input-large label { cursor: pointer; font-size: 1.8rem; color: var(--gray-medium); transition: var(--transition); }
    .rating-stars-input-large input:checked ~ label,
    .rating-stars-input-large label:hover,
    .rating-stars-input-large label:hover ~ label { color: #ffc107; }

    .user-avatar-placeholder { width: 45px; height: 45px; background-color: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0; }
    .review-header-flex { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
    .user-info { display: flex; align-items: center; gap: 15px; }
    .review-user-name { font-weight: 700; color: var(--primary-dark); margin: 0; }
    .stars-gold-sm { color: #ffc107; font-size: 0.8rem; }
    .review-date-tag { font-size: 0.8rem; color: var(--text-muted); }
    .review-body-text { color: var(--text-color); line-height: 1.6; font-style: italic; font-size: 1.05rem; }

    @media (max-width: 1024px) {
        .spectacle-flex-wrapper { flex-direction: column; }
        .spectacle-poster-side { width: 100%; height: 500px; }
        .reviews-layout { grid-template-columns: 1fr; }
        .spectacle-title-main { font-size: 2.5rem; }
    }
</style>
@endpush

@push('scripts')
<script>
// (Скрипты остаются без изменений, только адаптируем под новую верстку если нужно)
let selectedShowId = null;

function selectShow(showId) {
    selectedShowId = showId;
    document.querySelectorAll('.show-card-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.showId == showId);
    });
    loadHallSchema(showId);
}

function loadHallSchema(showId) {
    const container = document.getElementById('hall-schema-container');
    container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-3x" style="color: var(--primary-color);"></i><p class="mt-4">Подготовка схемы зала...</p></div>';
    
    fetch(`/api/shows/${showId}/seats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) renderHallSchema(data);
            else container.innerHTML = '<div class="text-center">Ошибка загрузки. Попробуйте еще раз.</div>';
        })
        .catch(() => container.innerHTML = '<div class="text-center">Ошибка соединения.</div>');
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

// Функции таймера и выбора мест остаются такими же по логике
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
            alert('Время резервирования истекло.');
            location.reload();
        } else {
            timeLeft--;
            const m = Math.floor(timeLeft / 60), s = timeLeft % 60;
            document.getElementById('timer').textContent = `${m}:${s.toString().padStart(2, '0')}`;
        }
    }, 1000);
}

function confirmSelection() {
    if (selectedSeats.length === 0) return;
    @auth
        fetch(`/api/shows/${window.currentShowId}/reserve`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ seats: selectedSeats })
        })
        .then(r => r.json())
        .then(d => d.success ? window.location.href = d.redirect_url : alert(d.error))
        .catch(() => alert('Ошибка при оформлении.'));
    @else
        window.location.href = '{{ route("login") }}';
    @endauth
}
</script>
@endpush
@endsection

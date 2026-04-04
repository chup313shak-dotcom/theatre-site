<!-- resources/views/front/partials/hall-schema.blade.php -->
<div x-data="hallSchema()" x-init="init()" class="hall-schema">
    <div class="text-center mb-5">
        <h3 class="page-title">Схема зала</h3>
        <p class="page-subtitle">Выберите подходящие места на схеме</p>
    </div>

    <!-- Сцена -->
    <div class="stage-container">
        <div class="stage-box">
            <i class="fas fa-theater-masks mr-2"></i> СЦЕНА
        </div>
    </div>

    <!-- Зрительный зал -->
    <div class="hall-container">
        <template x-for="row in hallSchema.rows" :key="row.row">
            <div class="hall-row">
                <div class="row-number" x-text="row.row"></div>
                <div class="seats-row">
                    <template x-for="seat in row.seats" :key="seat.number">
                        <button 
                            @click="toggleSeat(row.row, seat.number, seat.price)"
                            :title="'Ряд ' + row.row + ', Место ' + seat.number + ' - ' + seat.price + ' ₽'"
                            :class="{
                                'seat-selected': isSelected(row.row, seat.number),
                                'seat-occupied': isOccupied(row.row, seat.number),
                                'seat-available': !isSelected(row.row, seat.number) && !isOccupied(row.row, seat.number)
                            }"
                            :disabled="isOccupied(row.row, seat.number)"
                            class="seat-btn"
                            x-text="seat.number"
                        ></button>
                    </template>
                </div>
                <div class="row-number" x-text="row.row"></div>
            </div>
        </template>
    </div>

    <!-- Легенда -->
    <div class="hall-legend">
        <div class="legend-item">
            <div class="legend-color seat-available"></div>
            <span>Свободно</span>
        </div>
        <div class="legend-item">
            <div class="legend-color seat-selected"></div>
            <span>Выбрано</span>
        </div>
        <div class="legend-item">
            <div class="legend-color seat-occupied"></div>
            <span>Занято</span>
        </div>
    </div>

    <!-- Информация о выбранных местах -->
    <div x-show="selectedSeats.length > 0" 
         x-transition.duration.300ms
         class="selected-info-card mt-5">
        <div class="card">
            <div class="card-header bg-primary-dark text-white">
                <h4 class="card-title mb-0"><i class="fas fa-shopping-basket mr-2"></i> Ваш выбор</h4>
            </div>
            <div class="card-body">
                <div class="selected-seats-grid">
                    <template x-for="seat in selectedSeats" :key="seat.row + '_' + seat.seat">
                        <div class="seat-ticket-mini">
                            <div class="ticket-info">
                                <span class="ticket-place">Ряд <span x-text="seat.row"></span>, Место <span x-text="seat.seat"></span></span>
                                <span class="ticket-price" x-text="seat.price + ' ₽'"></span>
                            </div>
                            <button @click="removeSeat(seat.row, seat.seat)" class="btn-remove-ticket" title="Убрать">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </template>
                </div>
                
                <div class="selection-footer mt-4">
                    <div class="selection-stats">
                        <div class="stat-line">
                            <span>Билетов:</span>
                            <strong x-text="selectedSeats.length"></strong>
                        </div>
                        <div class="stat-line total">
                            <span>К оплате:</span>
                            <strong x-text="totalPrice + ' ₽'"></strong>
                        </div>
                    </div>
                    
                    <div class="selection-actions">
                        <div class="timer-display mb-3">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            Резерв на: <span x-text="formatTime(reservationTimeout)" class="time-value"></span>
                        </div>
                        <button @click="confirmSelection" class="btn btn-primary btn-lg btn-block">
                            Оформить заказ — <span x-text="totalPrice + ' ₽'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Сообщение о необходимости авторизации -->
    <div x-show="!isAuthenticated && selectedSeats.length > 0" 
         class="alert alert-warning mt-4 text-center">
        <i class="fas fa-user-lock mr-2"></i>
        Чтобы продолжить, пожалуйста <a href="{{ route('login') }}" class="font-bold underline">войдите</a> или 
        <a href="{{ route('register') }}" class="font-bold underline">зарегистрируйтесь</a>
    </div>
</div>

<style>
    .hall-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-x: auto;
        padding: 20px 0;
        margin: 0 auto;
        max-width: 100%;
    }
    .hall-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        min-width: min-content;
    }
    .seats-row {
        display: flex;
        gap: 6px;
    }
    .row-number {
        width: 25px;
        font-weight: 700;
        color: var(--text-muted);
        font-size: 0.8rem;
    }
    .seat-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .seat-available { background-color: var(--primary-color); color: white; }
    .seat-available:hover { background-color: var(--primary-dark); transform: translateY(-2px); }
    .seat-selected { background-color: var(--success-color); color: white; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3); }
    .seat-occupied { background-color: #e9ecef; color: #adb5bd; cursor: not-allowed; }
    
    .stage-container { margin-bottom: 40px; }
    .stage-box {
        max-width: 600px;
        margin: 0 auto;
        padding: 15px;
        background: linear-gradient(to bottom, #f8f9fa, #dee2e6);
        border-bottom: 4px solid var(--primary-color);
        border-radius: 0 0 50% 50% / 0 0 20px 20px;
        font-weight: 800;
        color: var(--primary-dark);
        letter-spacing: 5px;
    }
    
    .hall-legend {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 30px;
        padding: 20px;
        background-color: var(--gray-light);
        border-radius: 12px;
    }
    .legend-item { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; }
    .legend-color { width: 20px; height: 20px; border-radius: 4px; }
    
    .selected-seats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    .seat-ticket-mini {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        background-color: var(--gray-light);
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
    }
    .ticket-place { display: block; font-weight: 700; color: var(--primary-dark); font-size: 0.9rem; }
    .ticket-price { font-weight: 600; color: var(--primary-color); font-size: 0.85rem; }
    .btn-remove-ticket { background: none; border: none; color: #adb5bd; cursor: pointer; transition: 0.2s; }
    .btn-remove-ticket:hover { color: var(--error-color); }
    
    .selection-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-top: 20px;
        border-top: 2px solid var(--gray-medium);
    }
    .stat-line { display: flex; justify-content: space-between; gap: 20px; margin-bottom: 5px; }
    .stat-line.total { font-size: 1.5rem; color: var(--primary-dark); }
    .stat-line.total strong { color: var(--primary-color); }
    
    .time-value { color: var(--primary-color); font-weight: 800; }
</style>

<script>
function hallSchema() {
    return {
        showId: {{ $show->id ?? 0 }},
        hallSchema: { rows: [] },
        selectedSeats: [],
        totalPrice: 0,
        occupiedSeats: {},
        reservationTimeout: 600, // 10 минут в секундах
        isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
        timerInterval: null,
        
        async init() {
            if (!this.showId) {
                console.error('Show ID not provided');
                return;
            }
            await this.loadHallSchema();
            this.startAutoRefresh();
            this.startTimer();
        },
        
        async loadHallSchema() {
            try {
                const response = await fetch(`/api/shows/${this.showId}/seats`);
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();
                this.hallSchema = data.hall_schema;
                this.reservationTimeout = data.reservation_timeout || 600;
                
                // Отмечаем занятые места
                this.occupiedSeats = {};
                this.hallSchema.rows.forEach(row => {
                    row.seats.forEach(seat => {
                        if (seat.status === 'sold' || seat.status === 'reserved' || seat.status === 'occupied') {
                            this.occupiedSeats[`${row.row}_${seat.number}`] = true;
                        }
                    });
                });
            } catch (error) {
                console.error('Error loading hall schema:', error);
            }
        },
        
        isSelected(row, seat) {
            return this.selectedSeats.some(s => s.row === row && s.seat === seat);
        },
        
        isOccupied(row, seat) {
            return this.occupiedSeats[`${row}_${seat}`] === true;
        },
        
        toggleSeat(row, seat, price) {
            if (!this.isAuthenticated) {
                alert('Для выбора мест необходимо войти в систему');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            if (this.isOccupied(row, seat)) return;
            
            const index = this.selectedSeats.findIndex(s => s.row === row && s.seat === seat);
            if (index === -1) {
                this.selectedSeats.push({ row, seat, price });
                this.totalPrice += price;
            } else {
                this.totalPrice -= this.selectedSeats[index].price;
                this.selectedSeats.splice(index, 1);
            }
        },
        
        removeSeat(row, seat) {
            const index = this.selectedSeats.findIndex(s => s.row === row && s.seat === seat);
            if (index !== -1) {
                this.totalPrice -= this.selectedSeats[index].price;
                this.selectedSeats.splice(index, 1);
            }
        },
        
        async confirmSelection() {
            if (this.selectedSeats.length === 0) {
                alert('Выберите места');
                return;
            }
            
            if (!this.isAuthenticated) {
                alert('Для покупки билетов необходимо войти в систему');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            const confirmMessage = `Вы выбрали ${this.selectedSeats.length} мест(а). Продолжить?`;
            if (!confirm(confirmMessage)) return;
            
            try {
                const response = await fetch(`/api/shows/${this.showId}/reserve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ seats: this.selectedSeats })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    window.location.href = `/checkout/${data.order_id}`;
                } else {
                    const error = await response.json();
                    alert(error.error || 'Ошибка при резервировании мест');
                    this.selectedSeats = [];
                    await this.loadHallSchema(); // Перезагружаем схему
                }
            } catch (error) {
                console.error('Error reserving seats:', error);
                alert('Ошибка соединения. Попробуйте позже.');
            }
        },
        
        startAutoRefresh() {
            setInterval(() => {
                this.loadHallSchema();
                // Очищаем выбранные места, если они стали занятыми
                this.selectedSeats = this.selectedSeats.filter(seat => 
                    !this.isOccupied(seat.row, seat.seat)
                );
            }, 30000); // Обновляем каждые 30 секунд
        },
        
        startTimer() {
            if (this.timerInterval) clearInterval(this.timerInterval);
            this.timerInterval = setInterval(() => {
                if (this.reservationTimeout > 0) {
                    this.reservationTimeout--;
                }
            }, 1000);
        },
        
        formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${minutes}:${secs.toString().padStart(2, '0')}`;
        }
    }
}
</script>

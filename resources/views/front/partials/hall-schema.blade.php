<!-- resources/views/front/partials/hall-schema.blade.php -->
<div x-data="hallSchema()" x-init="init()" class="hall-schema">
    <div class="text-center mb-6">
        <h3 class="text-xl font-bold">Схема зала</h3>
        <p class="text-gray-600">Выберите места</p>
    </div>

    <!-- Сцена -->
    <div class="stage text-center mb-8">
        <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-3 rounded-lg w-3/4 mx-auto shadow-lg">
            <i class="fas fa-microphone-alt mr-2"></i>СЦЕНА
        </div>
    </div>

    <!-- Зрительный зал -->
    <div class="hall flex flex-col items-center space-y-2 overflow-x-auto pb-4">
        <template x-for="row in hallSchema.rows" :key="row.row">
            <div class="flex justify-center items-center space-x-2 min-w-max">
                <div class="w-12 text-right font-bold text-gray-700" x-text="row.row"></div>
                <div class="flex space-x-1">
                    <template x-for="seat in row.seats" :key="seat.number">
                        <button 
                            @click="toggleSeat(row.row, seat.number)"
                            :class="{
                                'bg-green-500 hover:bg-green-600 shadow-lg transform scale-105': isSelected(row.row, seat.number),
                                'bg-gray-300 cursor-not-allowed opacity-50': isOccupied(row.row, seat.number),
                                'bg-blue-500 hover:bg-blue-600 hover:shadow-md': !isSelected(row.row, seat.number) && !isOccupied(row.row, seat.number)
                            }"
                            :disabled="isOccupied(row.row, seat.number)"
                            class="w-10 h-10 rounded-lg text-white font-bold transition-all duration-200 text-sm"
                            x-text="seat.number"
                        ></button>
                    </template>
                </div>
            </div>
        </template>
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

    <!-- Информация о выбранных местах -->
    <div x-show="selectedSeats.length > 0" 
         x-transition.duration.300ms
         class="selected-info mt-6 p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg border border-green-200">
        <h4 class="font-bold text-gray-800 mb-3">Выбранные места:</h4>
        <div class="flex flex-wrap gap-2 mb-4">
            <template x-for="seat in selectedSeats">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm flex items-center">
                    <i class="fas fa-chair mr-1"></i>
                    <span x-text="seat.row + seat.seat"></span>
                    <button @click="removeSeat(seat.row, seat.seat)" class="ml-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </span>
            </template>
        </div>
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <i class="fas fa-clock mr-1"></i>
                Время резерва: <span x-text="formatTime(reservationTimeout)"></span>
            </div>
            <button @click="confirmSelection" 
                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors shadow-md">
                <i class="fas fa-ticket-alt mr-2"></i>
                Подтвердить выбор ( <span x-text="selectedSeats.length"></span> )
            </button>
        </div>
    </div>
    
    <!-- Сообщение о необходимости авторизации -->
    <div x-show="!isAuthenticated && selectedSeats.length > 0" 
         class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        Для покупки билетов необходимо <a href="{{ route('login') }}" class="underline font-bold">войти</a> или 
        <a href="{{ route('register') }}" class="underline font-bold">зарегистрироваться</a>
    </div>
</div>

<script>
function hallSchema() {
    return {
        showId: {{ $show->id ?? 0 }},
        hallSchema: { rows: [] },
        selectedSeats: [],
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
                        if (seat.status === 'occupied' || seat.status === 'reserved') {
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
        
        toggleSeat(row, seat) {
            if (!this.isAuthenticated) {
                alert('Для выбора мест необходимо войти в систему');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            if (this.isOccupied(row, seat)) return;
            
            const index = this.selectedSeats.findIndex(s => s.row === row && s.seat === seat);
            if (index === -1) {
                this.selectedSeats.push({ row, seat });
            } else {
                this.selectedSeats.splice(index, 1);
            }
        },
        
        removeSeat(row, seat) {
            const index = this.selectedSeats.findIndex(s => s.row === row && s.seat === seat);
            if (index !== -1) {
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
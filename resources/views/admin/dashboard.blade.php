@extends('layouts.admin')

@section('title', 'Дашборд')
@section('header', 'Обзор системы')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-red-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Спектакли</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['spectacles_count'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center text-red-600">
                <i class="fas fa-theater-masks text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.spectacles.index') }}" class="mt-4 text-xs text-red-600 hover:underline flex items-center">
            Управление <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Показы</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['shows_count'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.shows.index') }}" class="mt-4 text-xs text-blue-600 hover:underline flex items-center">
            Афиша <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-green-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Заказы</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['orders_count'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                <i class="fas fa-ticket-alt text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="mt-4 text-xs text-green-600 hover:underline flex items-center">
            Все заказы <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-purple-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Пользователи</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['users_count'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}" class="mt-4 text-xs text-purple-600 hover:underline flex items-center">
            Управление <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Общая выручка</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_revenue'], 0, '.', ' ') }} ₽</h3>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-600">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="mt-4 text-xs text-yellow-600 hover:underline flex items-center">
            Аналитика заказов <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Revenue Chart -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <h3 class="font-bold text-gray-800 mb-6">Динамика выручки за неделю</h3>
    <div class="h-64">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800">Последние заказы</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-red-600 hover:underline">Смотреть все</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                        <th class="px-6 py-3">№</th>
                        <th class="px-6 py-3">Клиент</th>
                        <th class="px-6 py-3">Сумма</th>
                        <th class="px-6 py-3">Статус</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-bold">{{ number_format($order->total_amount, 0, '.', ' ') }} ₽</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($order->status === 'paid') bg-green-100 text-green-700 
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">Заказов пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upcoming Shows -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800">Ближайшие показы</h3>
            <a href="{{ route('admin.shows.index') }}" class="text-xs text-red-600 hover:underline">Вся афиша</a>
        </div>
        <div class="p-6 space-y-4">
            @forelse($upcomingShows as $show)
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex flex-col items-center justify-center text-red-600">
                        <span class="text-xs font-bold leading-none">{{ $show->start_time->format('d') }}</span>
                        <span class="text-[10px] uppercase {!! $show->start_time->translatedFormat('M') !!}</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-800">{{ $show->spectacle->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $show->start_time->format('H:i') }} • {{ $show->venue ?? 'Основная сцена' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-400">
                            {{ $show->tickets_count ?? 0 }} / {{ $show->total_seats ?? 100 }} бил.
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 italic py-10">Показов не запланировано</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueData->pluck('date')) !!},
            datasets: [{
                label: 'Выручка (₽)',
                data: {!! json_encode($revenueData->pluck('total')) !!},
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
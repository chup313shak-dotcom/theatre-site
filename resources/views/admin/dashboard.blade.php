@extends('layouts.admin')

@section('title', 'Дашборд')
@section('header', 'Обзор системы')

@section('content')
<div class="admin-dashboard">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-soft">
                <i class="fas fa-theater-masks"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Спектакли</p>
                <h3 class="stat-value">{{ $spectaclesCount }}</h3>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-green-soft">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Показы</p>
                <h3 class="stat-value">{{ $showsCount }}</h3>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-purple-soft">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Заказы</p>
                <h3 class="stat-value">{{ $ordersCount }}</h3>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-yellow-soft">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Пользователи</p>
                <h3 class="stat-value">{{ $usersCount }}</h3>
            </div>
        </div>
    </div>

    <div class="dashboard-grid mt-4">
        <!-- Recent Orders -->
        <div class="dashboard-card main-card">
            <div class="card-header">
                <h3 class="card-title">Последние заказы</h3>
                <a href="{{ route('admin.orders.index') }}" class="btn-link">Все заказы</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ number_format($order->total_amount, 0, '.', ' ') }} ₽</td>
                            <td>
                                <span class="badge badge-{{ $order->status === 'paid' ? 'success' : ($order->status === 'pending' ? 'warning' : 'primary') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

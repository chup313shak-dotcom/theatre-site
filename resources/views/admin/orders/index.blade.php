@extends('layouts.admin')

@section('title', 'Заказы')
@section('header', 'Управление заказами')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Все заказы билетов</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th>Пользователь</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th class="text-right">Управление статусом</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <div class="admin-table-title">{{ $order->user->name }}</div>
                                <div class="admin-table-subtitle">{{ $order->user->email }}</div>
                            </td>
                            <td>
                                <div class="admin-table-title">{{ number_format($order->total_amount, 0, '.', ' ') }} ₽</div>
                            </td>
                            <td>
                                @if($order->status === 'paid')
                                    <span class="badge badge-success">Оплачен</span>
                                @elseif($order->status === 'pending')
                                    <span class="badge badge-warning">Ожидание</span>
                                @else
                                    <span class="badge">Отменен</span>
                                @endif
                            </td>
                            <td>
                                <div class="admin-table-subtitle">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-form">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 5px 10px; font-size: 0.85rem; min-width: 120px;">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидание</option>
                                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Оплачен</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center italic">Заказов пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($orders->hasPages())
        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

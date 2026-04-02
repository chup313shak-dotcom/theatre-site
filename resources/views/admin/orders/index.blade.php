@extends('layouts.admin')

@section('title', 'Заказы')
@section('header', 'Управление заказами')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="font-bold text-gray-800">Все заказы билетов</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Пользователь</th>
                    <th class="px-6 py-3">Сумма</th>
                    <th class="px-6 py-3">Статус</th>
                    <th class="px-6 py-3">Дата</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-sm font-medium">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold">{{ number_format($order->total_amount, 0, '.', ' ') }} ₽</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($order->status === 'paid') bg-green-100 text-green-700 
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $order->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидание</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Оплачен</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">Заказов пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
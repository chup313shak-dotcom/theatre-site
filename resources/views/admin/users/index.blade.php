@extends('layouts.admin')

@section('title', 'Пользователи')
@section('header', 'Управление пользователями')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="font-bold text-gray-800">Все пользователи системы</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    <th class="px-6 py-3">Имя</th>
                    <th class="px-6 py-3">Email / Телефон</th>
                    <th class="px-6 py-3">Роль</th>
                    <th class="px-6 py-3">Дата регистрации</th>
                    <th class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            <div class="text-xs text-gray-500">{{ $user->phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($user->isAdmin()) bg-red-100 text-red-700 
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="inline-flex items-center">
                                @csrf
                                <select name="role" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Менеджер</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Админ</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
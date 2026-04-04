@extends('layouts.admin')

@section('title', 'Пользователи')
@section('header', 'Управление пользователями')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Список зарегистрированных пользователей</h3>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя / Email</th>
                    <th>Телефон</th>
                    <th>Роль</th>
                    <th>Зарегистрирован</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>
                            <div class="admin-table-title">{{ $user->name }}</div>
                            <div class="admin-table-subtitle">{{ $user->email }}</div>
                        </td>
                        <td>{{ $user->phone ?? 'Не указан' }}</td>
                        <td>
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="inline-role-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                
                                <select name="role" onchange="this.form.submit()" 
                                        class="form-control form-control-sm {{ $user->isAdmin() ? 'border-warning' : 'border-primary' }}"
                                        {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Клиент</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Админ</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="text-right">
                            <div class="admin-actions">
                                @if($user->id !== Auth::id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Вы уверены?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Удалить">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted italic">Пользователей пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="pagination-container">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection

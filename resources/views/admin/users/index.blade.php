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
                            @if($user->isAdmin())
                                <span class="badge badge-warning">Админ</span>
                            @else
                                <span class="badge badge-primary">Клиент</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="text-right">
                            <div class="admin-actions">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn edit-btn" title="Редактировать">
                                    <i class="fas fa-user-edit"></i>
                                </a>
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

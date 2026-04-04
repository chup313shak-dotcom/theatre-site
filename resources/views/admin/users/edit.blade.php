@extends('layouts.admin')

@section('title', 'Изменить роль')
@section('header', 'Управление ролями')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Пользователь: {{ $user->name }} ({{ $user->email }})</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            
            <!-- Скрытые поля для сохранения текущих данных (чтобы валидация в контроллере прошла) -->
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="email" value="{{ $user->email }}">

            <div class="form-group" style="max-width: 400px;">
                <label class="form-label">Назначить роль</label>
                <select name="role" class="form-control">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Клиент</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Администратор</option>
                </select>
                <p class="form-hint">Администратор имеет полный доступ к управлению сайтом.</p>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-shield mr-2"></i> Обновить роль
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

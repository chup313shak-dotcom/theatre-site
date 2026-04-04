@extends('layouts.admin')

@section('title', 'Добавить событие')
@section('header', 'Новое событие в афише')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Введите данные сеанса</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.shows.store') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <!-- Спектакль -->
                <div class="form-group">
                    <label class="form-label">Выберите спектакль</label>
                    <select name="spectacle_id" required class="form-control">
                        <option value="">-- Выберите из списка --</option>
                        @foreach($spectacles as $spectacle)
                            <option value="{{ $spectacle->id }}" {{ old('spectacle_id') == $spectacle->id ? 'selected' : '' }}>
                                {{ $spectacle->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Дата и время -->
                <div class="form-group">
                    <label class="form-label">Дата и время начала</label>
                    <input type="datetime-local" name="start_time" required value="{{ old('start_time') }}" 
                           class="form-control">
                </div>

                <!-- Место проведения -->
                <div class="form-group">
                    <label class="form-label">Место проведения</label>
                    <input type="text" name="location" value="{{ old('location', 'Основная сцена') }}" 
                           class="form-control" placeholder="Напр: Основная сцена">
                </div>
            </div>

            <!-- Статус -->
            <div class="form-group mt-4">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span>Активен (доступен для покупки билетов)</span>
                </label>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.shows.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Добавить в афишу
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-weight: 500;
    }
    .checkbox-label input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
</style>
@endsection

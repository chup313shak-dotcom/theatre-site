@extends('layouts.admin')

@section('title', 'Редактировать событие')
@section('header', 'Редактирование сеанса')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Измените данные сеанса</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.shows.update', $show) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Спектакль -->
                <div class="form-group">
                    <label class="form-label">Выберите спектакль</label>
                    <select name="spectacle_id" required class="form-control">
                        <option value="">-- Выберите из списка --</option>
                        @foreach($spectacles as $spectacle)
                            <option value="{{ $spectacle->id }}" 
                                {{ old('spectacle_id', $show->spectacle_id) == $spectacle->id ? 'selected' : '' }}>
                                {{ $spectacle->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Дата и время -->
                <div class="form-group">
                    <label class="form-label">Дата и время начала</label>
                    <input type="datetime-local" name="start_time" required 
                           value="{{ old('start_time', \Carbon\Carbon::parse($show->start_time)->format('Y-m-d\TH:i')) }}" 
                           class="form-control">
                </div>

                <!-- Место проведения -->
                <div class="form-group">
                    <label class="form-label">Место проведения</label>
                    <input type="text" name="location" value="{{ old('location', $show->location) }}" 
                           class="form-control" placeholder="Напр: Основная сцена">
                </div>
            </div>

            <!-- Статус -->
            <div class="form-group mt-4">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" 
                        {{ old('is_active', $show->is_active) ? 'checked' : '' }}>
                    <span>Активен (доступен для покупки билетов)</span>
                </label>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.shows.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить изменения
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
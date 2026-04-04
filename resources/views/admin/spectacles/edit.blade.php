@extends('layouts.admin')

@section('title', 'Редактировать спектакль')
@section('header', 'Редактирование спектакля')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Спектакль: {{ $spectacle->title }}</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.spectacles.update', $spectacle->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Название -->
                <div class="form-group">
                    <label class="form-label">Название (RU)</label>
                    <input type="text" name="title" required value="{{ old('title', $spectacle->title) }}" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Название (TAT)</label>
                    <input type="text" name="title_tatar" value="{{ old('title_tatar', $spectacle->title_tatar) }}" 
                           class="form-control">
                </div>

                <!-- Режиссер и Длительность -->
                <div class="form-group">
                    <label class="form-label">Режиссер</label>
                    <input type="text" name="director" required value="{{ old('director', $spectacle->director) }}" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Длительность (мин)</label>
                    <input type="number" name="duration" required value="{{ old('duration', $spectacle->duration) }}" 
                           class="form-control">
                </div>

                <!-- Жанр и Возрастной ценз -->
                <div class="form-group">
                    <label class="form-label">Жанр</label>
                    <input type="text" name="genre" value="{{ old('genre', $spectacle->genre) }}" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Возрастной ценз</label>
                    <select name="age_limit" class="form-control">
                        @foreach(['0+', '6+', '12+', '16+', '18+'] as $age)
                            <option value="{{ $age }}" {{ old('age_limit', $spectacle->age_limit) == $age ? 'selected' : '' }}>{{ $age }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Описание -->
            <div class="form-group mt-4">
                <label class="form-label">Описание спектакля</label>
                <textarea name="description" rows="5" 
                          class="form-control">{{ old('description', $spectacle->description) }}</textarea>
            </div>

            <!-- Текущий постер -->
            @if($spectacle->poster)
            <div class="form-group mt-4">
                <label class="form-label">Текущий постер</label>
                <div class="admin-table-img" style="width: 120px; height: 180px;">
                    <img src="{{ str_starts_with($spectacle->poster, 'http') ? $spectacle->poster : asset($spectacle->poster) }}" 
                         alt="{{ $spectacle->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>
            </div>
            @endif

            <!-- Постер -->
            <div class="form-group mt-4">
                <label class="form-label">Заменить постер</label>
                <div class="file-input-wrapper">
                    <input type="file" name="poster" id="poster" class="file-input">
                    <label for="poster" class="file-label">
                        <i class="fas fa-image"></i> Выберите файл
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.spectacles.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

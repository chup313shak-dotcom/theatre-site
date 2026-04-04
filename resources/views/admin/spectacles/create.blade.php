@extends('layouts.admin')

@section('title', 'Добавить спектакль')
@section('header', 'Новый спектакль')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Введите данные о спектакле</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.spectacles.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <!-- Название -->
                <div class="form-group">
                    <label class="form-label">Название (RU)</label>
                    <input type="text" name="title" required value="{{ old('title') }}" 
                           class="form-control" placeholder="Напр: Гамлет">
                </div>

                <div class="form-group">
                    <label class="form-label">Название (TAT)</label>
                    <input type="text" name="title_tatar" value="{{ old('title_tatar') }}" 
                           class="form-control" placeholder="Напр: Гамлет (тат)">
                </div>

                <!-- Режиссер и Длительность -->
                <div class="form-group">
                    <label class="form-label">Режиссер</label>
                    <input type="text" name="director" required value="{{ old('director') }}" 
                           class="form-control" placeholder="ФИО режиссера">
                </div>

                <div class="form-group">
                    <label class="form-label">Длительность (мин)</label>
                    <input type="number" name="duration" required value="{{ old('duration') }}" 
                           class="form-control" placeholder="Напр: 120">
                </div>

                <!-- Жанр и Возрастной ценз -->
                <div class="form-group">
                    <label class="form-label">Жанр</label>
                    <input type="text" name="genre" value="{{ old('genre') }}" 
                           class="form-control" placeholder="Напр: Трагедия">
                </div>

                <div class="form-group">
                    <label class="form-label">Возрастной ценз</label>
                    <select name="age_limit" class="form-control">
                        <option value="0+" {{ old('age_limit') == '0+' ? 'selected' : '' }}>0+</option>
                        <option value="6+" {{ old('age_limit') == '6+' ? 'selected' : '' }}>6+</option>
                        <option value="12+" {{ old('age_limit') == '12+' ? 'selected' : '' }}>12+</option>
                        <option value="16+" {{ old('age_limit') == '16+' ? 'selected' : '' }}>16+</option>
                        <option value="18+" {{ old('age_limit') == '18+' ? 'selected' : '' }}>18+</option>
                    </select>
                </div>
            </div>

            <!-- Описание -->
            <div class="form-group mt-4">
                <label class="form-label">Описание спектакля</label>
                <textarea name="description" rows="5" placeholder="Краткая аннотация..."
                          class="form-control">{{ old('description') }}</textarea>
            </div>

            <!-- Постер -->
            <div class="form-group mt-4">
                <label class="form-label">Постер спектакля</label>
                <div class="file-input-wrapper">
                    <input type="file" name="poster" id="poster" class="file-input">
                    <label for="poster" class="file-label">
                        <i class="fas fa-cloud-upload-alt"></i> Выберите файл
                    </label>
                </div>
                <small class="form-hint">Рекомендуемый размер: 600x900px, формат JPG или PNG.</small>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.spectacles.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить спектакль
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

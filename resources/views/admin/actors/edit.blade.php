@extends('layouts.admin')

@section('title', 'Редактировать артиста')
@section('header', 'Редактирование профиля')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Данные артиста: {{ $actor->name }}</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.actors.update', $actor->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Имя -->
                <div class="form-group">
                    <label class="form-label">Имя (RU)</label>
                    <input type="text" name="name" required value="{{ old('name', $actor->name) }}" 
                           class="form-control" placeholder="Напр: Иван Иванов">
                </div>

                <div class="form-group">
                    <label class="form-label">Имя (TAT)</label>
                    <input type="text" name="name_tatar" value="{{ old('name_tatar', $actor->name_tatar) }}" 
                           class="form-control" placeholder="Напр: Илдар Ильдаров (тат)">
                </div>

                <!-- Категория -->
                <div class="form-group">
                    <label class="form-label">Категория / Звание</label>
                    <select name="category" class="form-control">
                        <option value="АРТИСТ" {{ old('category', $actor->category) == 'АРТИСТ' ? 'selected' : '' }}>АРТИСТ</option>
                        <option value="ЗАСЛУЖЕННЫЙ АРТИСТ" {{ old('category', $actor->category) == 'ЗАСЛУЖЕННЫЙ АРТИСТ' ? 'selected' : '' }}>ЗАСЛУЖЕННЫЙ АРТИСТ</option>
                        <option value="НАРОДНЫЙ АРТИСТ" {{ old('category', $actor->category) == 'НАРОДНЫЙ АРТИСТ' ? 'selected' : '' }}>НАРОДНЫЙ АРТИСТ</option>
                    </select>
                </div>
            </div>

            <!-- Биография -->
            <div class="form-group mt-4">
                <label class="form-label">Биография / Описание</label>
                <textarea name="biography" rows="5" placeholder="Краткая информация..."
                          class="form-control">{{ old('biography', $actor->biography) }}</textarea>
            </div>

            <!-- Текущее фото -->
            @if($actor->photo)
            <div class="form-group mt-4">
                <label class="form-label">Текущее фото</label>
                <div class="admin-table-img" style="width: 150px; height: 150px;">
                    @php
                        $photoUrl = asset('images/default-actor.jpg');
                        if ($actor->photo) {
                            if (str_starts_with($actor->photo, 'http')) {
                                $photoUrl = $actor->photo;
                            } else {
                                $cleanPath = ltrim($actor->photo, '/');
                                if (file_exists(public_path($cleanPath))) {
                                    $photoUrl = asset($cleanPath);
                                } elseif (file_exists(public_path('images/actors/' . basename($cleanPath)))) {
                                    $photoUrl = asset('images/actors/' . basename($cleanPath));
                                } else {
                                    $photoUrl = asset('storage/' . $cleanPath);
                                }
                            }
                        }
                    @endphp
                    <img src="{{ $photoUrl }}" alt="{{ $actor->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>
            </div>
            @endif

            <!-- Загрузка нового фото -->
            <div class="form-group mt-4">
                <label class="form-label">Заменить фото</label>
                <div class="file-input-wrapper">
                    <input type="file" name="photo" id="photo" class="file-input">
                    <label for="photo" class="file-label">
                        <i class="fas fa-cloud-upload-alt"></i> Выберите новый файл
                    </label>
                </div>
                <small class="form-hint">Оставьте пустым, если не хотите менять фото. Рекомендуется квадратное изображение.</small>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.actors.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

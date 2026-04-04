@extends('layouts.admin')

@section('title', 'Редактировать новость')
@section('header', 'Редактирование новости')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Новость: {{ $news->title }}</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Заголовок новости</label>
                <input type="text" name="title" required value="{{ old('title', $news->title) }}" 
                       class="form-control" placeholder="Введите заголовок...">
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Содержимое новости</label>
                <textarea name="content" rows="10" required placeholder="Текст новости..."
                          class="form-control">{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="form-grid mt-4">
                <div class="form-group">
                    <label class="form-label">Дата публикации</label>
                    <input type="datetime-local" name="published_at" 
                           value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Статус</label>
                    <label class="checkbox-label mt-2">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                        <span>Опубликовано</span>
                    </label>
                </div>
            </div>

            <!-- Текущее изображение -->
            @if($news->image)
            <div class="form-group mt-4">
                <label class="form-label">Текущее изображение</label>
                <div class="admin-table-img" style="width: 200px; height: 120px;">
                    <img src="{{ str_starts_with($news->image, 'http') ? $news->image : asset($news->image) }}" 
                         alt="{{ $news->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>
            </div>
            @endif

            <div class="form-group mt-4">
                <label class="form-label">Заменить изображение</label>
                <div class="file-input-wrapper">
                    <input type="file" name="image" id="image" class="file-input">
                    <label for="image" class="file-label">
                        <i class="fas fa-image"></i> Выберите файл
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Отмена</a>
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

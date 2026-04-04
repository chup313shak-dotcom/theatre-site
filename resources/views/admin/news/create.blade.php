@extends('layouts.admin')

@section('title', 'Добавить новость')
@section('header', 'Новая новость')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Создание новости</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Заголовок</label>
                    <input type="text" name="title" required value="{{ old('title') }}" 
                           class="form-control" placeholder="Заголовок новости">
                    @error('title') <span class="form-hint text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Дата публикации</label>
                    <input type="date" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" 
                           class="form-control">
                    @error('published_at') <span class="form-hint text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Изображение</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" class="file-input">
                        <label for="image" class="file-label">
                            <i class="fas fa-upload mr-2"></i> Выбрать файл...
                        </label>
                    </div>
                    <span class="form-hint">Рекомендуемый размер: 1200x600px</span>
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Краткое описание (excerpt)</label>
                <textarea name="excerpt" rows="3" 
                          class="form-control" placeholder="Краткий анонс новости для списка...">{{ old('excerpt') }}</textarea>
                @error('excerpt') <span class="form-hint text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Полный текст новости</label>
                <textarea name="content" rows="10" 
                          class="form-control" placeholder="Текст новости...">{{ old('content') }}</textarea>
                @error('content') <span class="form-hint text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Опубликовать новость
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

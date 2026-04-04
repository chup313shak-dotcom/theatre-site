@extends('layouts.admin')

@section('title', 'Добавить артиста')
@section('header', 'Новый артист')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Добавление артиста в труппу</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.actors.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Имя (RU)</label>
                    <input type="text" name="name" required value="{{ old('name') }}" 
                           class="form-control" placeholder="Напр: Иван Иванов">
                    @error('name') <span class="form-hint text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Имя (TAT)</label>
                    <input type="text" name="name_tatar" value="{{ old('name_tatar') }}" 
                           class="form-control" placeholder="Напр: Иван Иванов (на татарском)">
                    @error('name_tatar') <span class="form-hint text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Категория (звание)</label>
                    <input type="text" name="category" value="{{ old('category') }}" 
                           placeholder="Напр: Народный артист РТ"
                           class="form-control">
                    @error('category') <span class="form-hint text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Фото</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="photo" id="photo" class="file-input">
                        <label for="photo" class="file-label">
                            <i class="fas fa-upload mr-2"></i> Выбрать файл...
                        </label>
                    </div>
                    <span class="form-hint">Рекомендуемый размер: 600x800px (JPG, PNG)</span>
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Биография / Информация</label>
                <textarea name="biography" rows="6" 
                          class="form-control" placeholder="Краткая биография артиста...">{{ old('biography') }}</textarea>
                @error('biography') <span class="form-hint text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.actors.index') }}" class="btn btn-outline">Отмена</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Сохранить артиста
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

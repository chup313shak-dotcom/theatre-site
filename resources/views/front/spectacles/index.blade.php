@extends('layouts.app')

@section('title', 'Афиша спектаклей')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Афиша спектаклей</h1>
        <p class="page-subtitle">Выбирайте лучшие постановки нашего театра</p>
    </div>
    
    <!-- Фильтры -->
    <div class="filters-section">
        <form method="GET" action="{{ route('spectacles.index') }}" class="filters-form">
            <div class="filter-group">
                <label class="filter-label">Поиск</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Название спектакля..."
                       class="form-control">
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Жанр</label>
                <select name="genre" class="form-control">
                    <option value="">Все жанры</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Возраст</label>
                <select name="age" class="form-control">
                    <option value="">Любой</option>
                    @foreach($ageLimits as $age)
                        <option value="{{ $age }}" {{ request('age') == $age ? 'selected' : '' }}>
                            {{ $age }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Дата</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="form-control">
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Применить
                </button>
                @if(request()->anyFilled(['search', 'genre', 'age', 'date']))
                    <a href="{{ route('spectacles.index') }}" class="btn btn-link">
                        Сбросить
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Список спектаклей -->
    @if($spectacles->count() > 0)
        <div class="card-grid">
            @foreach($spectacles as $spectacle)
                <article class="card spectacle-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                             alt="{{ $spectacle->title }}"
                             class="card-image">
                        <div class="card-age-badge">
                            {{ $spectacle->age_limit }}
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $spectacle->title }}</h3>
                        <div class="card-info">
                            <p class="info-item">
                                <i class="fas fa-user"></i> {{ $spectacle->director }}
                            </p>
                            <p class="info-item">
                                <i class="fas fa-clock"></i> {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин
                            </p>
                            <p class="info-item rating-item">
                                <i class="fas fa-star text-warning"></i> {{ number_format($spectacle->rating, 1) }} 
                                <span class="review-count">({{ $spectacle->reviews_count }} отзывов)</span>
                            </p>
                        </div>
                        
                        @if($spectacle->shows->count() > 0)
                            <div class="upcoming-shows-compact">
                                <p class="shows-label">Ближайшие показы:</p>
                                @foreach($spectacle->shows->take(2) as $show)
                                    <span class="show-date-tag">{{ $show->start_time->format('d.m.Y H:i') }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <a href="{{ route('spectacles.show', $spectacle->id) }}" 
                           class="btn btn-primary card-btn">
                            Выбрать сеанс
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="pagination-wrapper text-center mt-4">
            {{ $spectacles->links() }}
        </div>
    @else
        <div class="empty-state text-center">
            <i class="fas fa-ticket-alt empty-icon"></i>
            <p class="empty-text">Спектакли не найдены по вашему запросу</p>
            <a href="{{ route('spectacles.index') }}" class="btn btn-outline">
                Показать все
            </a>
        </div>
    @endif
</div>
@endsection
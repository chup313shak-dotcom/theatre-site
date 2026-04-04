@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="container">
    <!-- Hero Slider -->
    <div class="hero-section" x-data="{ slide: 0 }">
        <div class="hero-image-container">
            <div class="hero-overlay"></div>
            <img src="/images/hero/theatre.jpg" alt="Театр" class="hero-image">
        </div>
        <div class="hero-content text-center">
            <div class="hero-text-box">
                <h1 class="hero-title">Добро пожаловать в театр!</h1>
                <p class="hero-subtitle">Откройте для себя мир искусства и эмоций</p>
                <a href="{{ route('spectacles.index') }}" class="btn btn-primary btn-lg">
                    Афиша спектаклей
                </a>
            </div>
        </div>
    </div>
    
    <!-- Ближайшие спектакли -->
    <section class="section upcoming-spectacles">
        <div class="section-header">
            <h2 class="section-title">Ближайшие спектакли</h2>
            <a href="{{ route('spectacles.index') }}" class="view-all-link">Все спектакли →</a>
        </div>
        
        <div class="card-grid">
            @foreach($upcomingShows as $spectacle)
                <article class="card spectacle-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                             alt="{{ $spectacle->title }}"
                             class="card-image">
                        <div class="card-badge">Скоро</div>
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
                            <p class="info-item date-item">
                                <i class="fas fa-calendar"></i> 
                                @if($spectacle->shows->first())
                                    {{ $spectacle->shows->first()->start_time->format('d.m.Y H:i') }}
                                @else
                                    Дата уточняется
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('spectacles.show', $spectacle->id) }}" 
                           class="btn btn-outline card-btn">
                            Подробнее
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    
    <!-- Новости -->
    <section class="section news-section">
        <div class="section-header">
            <h2 class="section-title">Новости театра</h2>
            <a href="{{ route('news.index') }}" class="view-all-link">Все новости →</a>
        </div>
        <div class="news-grid">
            @foreach($news as $item)
                <article class="news-item">
                    <div class="news-content-wrapper">
                        @if($item->image)
                            <div class="news-image-box">
                                <img src="{{ $item->image }}" alt="{{ $item->title }}" class="news-image">
                            </div>
                        @else
                            <div class="news-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        @endif
                        <div class="news-text-content">
                            <p class="news-date">{{ $item->published_at->format('d.m.Y') }}</p>
                            <h3 class="news-title">{{ $item->title }}</h3>
                            <p class="news-excerpt">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                            <a href="{{ route('news.show', $item->id) }}" class="news-more-link">
                                Читать далее →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    
    <!-- Цитата руководителя -->
    <section class="quote-section">
        <div class="quote-box text-center">
            <i class="fas fa-quote-left quote-icon"></i>
            <blockquote class="main-quote">
                "Театр — это не просто место, где показывают спектакли. Это место, где оживают мечты, 
                где каждый зритель становится соучастником волшебства."
            </blockquote>
            <cite class="quote-author">— Художественный руководитель театра</cite>
        </div>
    </section>
</div>
@endsection
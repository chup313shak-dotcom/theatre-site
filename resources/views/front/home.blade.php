@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<!-- Hero Slider (Full Width) -->
<section class="hero-slider" x-data="{ 
    activeSlide: 0, 
    slides: {{ $upcomingShows->count() }},
    next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
    init() { setInterval(() => this.next(), 7000) }
}">
    <div class="slider-container">
        @foreach($upcomingShows as $index => $spectacle)
            <div class="slide" x-show="activeSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform scale-105"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 style="display: none;">
                
                @php
                    $posterUrl = asset('images/default-poster.jpg');
                    if ($spectacle->poster) {
                        if (str_starts_with($spectacle->poster, 'http')) {
                            $posterUrl = $spectacle->poster;
                        } else {
                            $cleanPath = ltrim($spectacle->poster, '/');
                            $posterUrl = file_exists(public_path($cleanPath)) ? asset($cleanPath) : asset('storage/' . $cleanPath);
                        }
                    }
                    $nextShow = $spectacle->shows->where('start_time', '>', now())->first();
                @endphp

                <div class="slide-bg">
                    <div class="slide-overlay"></div>
                    <img src="{{ $posterUrl }}" alt="{{ $spectacle->title }}" class="slide-image">
                </div>

                <div class="container slide-content-container">
                    <div class="slide-info-box">
                        <div class="slide-age-limit">{{ $spectacle->age_limit }}</div>
                        
                        @if($nextShow)
                            <div class="slide-date-box">
                                <span class="date-day">{{ $nextShow->start_time->format('d') }}</span>
                                <div class="date-month-group">
                                    <span class="date-month">/ {{ $nextShow->start_time->translatedFormat('m') }}</span>
                                    <span class="date-day-name">{{ $nextShow->start_time->translatedFormat('l') }}</span>
                                </div>
                            </div>
                            <div class="slide-time">{{ $nextShow->start_time->format('H:i') }}</div>
                        @endif

                        <h2 class="slide-title">{{ $spectacle->title }}</h2>
                        
                        <div class="slide-actions">
                            <a href="{{ route('spectacles.show', $spectacle->id) }}" class="btn-buy-ticket">
                                <i class="fas fa-ticket-alt"></i>
                                <span>КУПИТЬ БИЛЕТ</span>
                                <div class="btn-arrow"><i class="fas fa-arrow-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Slider Pagination -->
    <div class="slider-pagination">
        <template x-for="i in slides" :key="i-1">
            <button @click="activeSlide = i-1" 
                    class="pagination-dot" 
                    :class="activeSlide === i-1 ? 'active' : ''"
                    x-text="i"></button>
        </template>
    </div>
</section>

<div class="container mt-5">
    <!-- Ближайшие спектакли -->
    <section class="section upcoming-spectacles">
        <div class="section-header">
            <h2 class="section-title">Афиша</h2>
            <a href="{{ route('spectacles.index') }}" class="view-all-link">Все спектакли →</a>
        </div>
        
        <div class="card-grid">
            @foreach($upcomingShows as $spectacle)
                <article class="card spectacle-card">
                    <div class="card-image-wrapper">
                        @php
                            $pUrl = asset('images/default-poster.jpg');
                            if ($spectacle->poster) {
                                if (str_starts_with($spectacle->poster, 'http')) { $pUrl = $spectacle->poster; }
                                else {
                                    $cP = ltrim($spectacle->poster, '/');
                                    $pUrl = file_exists(public_path($cP)) ? asset($cP) : asset('storage/' . $cP);
                                }
                            }
                        @endphp
                        <img src="{{ $pUrl }}" alt="{{ $spectacle->title }}" class="card-image">
                        <div class="card-badge">Скоро</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $spectacle->title }}</h3>
                        <div class="card-info">
                            <p class="info-item"><i class="fas fa-user"></i> {{ $spectacle->director }}</p>
                            <p class="info-item"><i class="fas fa-clock"></i> {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин</p>
                        </div>
                        <a href="{{ route('spectacles.show', $spectacle->id) }}" class="btn btn-outline card-btn">Подробнее</a>
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
                                @php
                                    $nUrl = asset('images/default-news.jpg');
                                    if ($item->image) {
                                        if (str_starts_with($item->image, 'http')) { $nUrl = $item->image; }
                                        else {
                                            $cnP = ltrim($item->image, '/');
                                            $nUrl = file_exists(public_path($cnP)) ? asset($cnP) : asset('storage/' . $cnP);
                                        }
                                    }
                                @endphp
                                <img src="{{ $nUrl }}" alt="{{ $item->title }}" class="news-image">
                            </div>
                        @else
                            <div class="news-placeholder"><i class="fas fa-newspaper"></i></div>
                        @endif
                        <div class="news-text-content">
                            <p class="news-date">{{ $item->published_at->format('d.m.Y') }}</p>
                            <h3 class="news-title">{{ $item->title }}</h3>
                            <a href="{{ route('news.show', $item->id) }}" class="news-more-link">Читать далее →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>
@endsection

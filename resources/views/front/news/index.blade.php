<!-- resources/views/front/news/index.blade.php -->
@extends('layouts.app')

@section('title', 'Новости театра')

@section('content')
<div class="container">
    <header class="page-header">
        <h1 class="page-title">Новости театра</h1>
        <p class="page-subtitle">Самые свежие события и анонсы нашего театра</p>
    </header>
    
    @if($news->count() > 0)
        <div class="news-list-vertical">
            @foreach($news as $item)
                <article class="news-card-horizontal card">
                    <div class="news-card-image">
                        @if($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="news-image">
                        @else
                            <div class="news-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        @endif
                    </div>
                    <div class="news-card-content">
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-calendar-alt"></i> {{ $item->published_at->format('d.m.Y') }}
                            </span>
                        </div>
                        <h2 class="news-title">
                            <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                        </h2>
                        <p class="news-excerpt">
                            {{ Str::limit(strip_tags($item->content), 200) }}
                        </p>
                        <a href="{{ route('news.show', $item->id) }}" class="btn btn-outline btn-sm">
                            Читать далее <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="pagination-wrapper mt-4">
            {{ $news->links() }}
        </div>
    @else
        <div class="empty-state text-center">
            <i class="fas fa-newspaper empty-icon"></i>
            <p class="empty-text">Новостей пока нет. Загляните позже!</p>
        </div>
    @endif
</div>

<style>
.news-list-vertical { display: flex; flex-direction: column; gap: 30px; margin-bottom: 50px; }
.news-card-horizontal { display: flex; flex-direction: row; overflow: hidden; min-height: 220px; }
.news-card-image { width: 300px; flex-shrink: 0; }
.news-image { width: 100%; height: 100%; object-fit: cover; }
.news-placeholder { width: 100%; height: 100%; background-color: var(--gray-medium); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--white); }
.news-card-content { padding: 30px; flex: 1; display: flex; flex-direction: column; }
.news-meta { margin-bottom: 10px; }
.news-date { font-size: 0.85rem; color: var(--primary-color); font-weight: 600; }
.news-title { font-size: 1.5rem; color: var(--primary-dark); margin-bottom: 15px; }
.news-title a:hover { color: var(--primary-color); }
.news-excerpt { color: var(--text-muted); line-height: 1.6; margin-bottom: 20px; flex: 1; }
.btn-sm { padding: 8px 18px; font-size: 0.9rem; }

@media (max-width: 768px) {
    .news-card-horizontal { flex-direction: column; }
    .news-card-image { width: 100%; height: 200px; }
}
</style>
@endsection

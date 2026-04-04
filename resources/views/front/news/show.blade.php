<!-- resources/views/front/news/show.blade.php -->
@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container">
    <article class="news-detail card">
        <!-- Заголовок и мета -->
        <header class="news-header-detail">
            <h1 class="page-title">{{ $news->title }}</h1>
            <div class="news-meta-detail">
                <span class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $news->published_at->format('d.m.Y') }}
                </span>
                @if($news->title_tatar)
                    <span class="meta-separator">•</span>
                    <span class="meta-item">
                        <i class="fas fa-language"></i>
                        {{ $news->title_tatar }}
                    </span>
                @endif
            </div>
        </header>
        
        <!-- Изображение -->
        @if($news->image)
            <div class="news-image-detail">
                <img src="{{ $news->image }}" alt="{{ $news->title }}" class="full-width-image">
            </div>
        @endif
        
        <!-- Контент -->
        <div class="news-content-detail prose">
            {!! $news->content !!}
        </div>
        
        <!-- Кнопка назад -->
        <footer class="news-footer-detail">
            <a href="{{ route('news.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
                Назад к новостям
            </a>
        </footer>
    </article>
    
    <!-- Похожие новости -->
    @if($relatedNews->count() > 0)
        <section class="section related-news">
            <h3 class="section-title">Другие новости</h3>
            <div class="card-grid">
                @foreach($relatedNews as $related)
                    <article class="card news-card-mini">
                        <div class="card-image-wrapper">
                            @if($related->image)
                                <img src="{{ $related->image }}" alt="{{ $related->title }}" class="card-image">
                            @else
                                <div class="news-placeholder-mini">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <span class="news-date-mini">{{ $related->published_at->format('d.m.Y') }}</span>
                            <h4 class="card-title-mini">{{ Str::limit($related->title, 60) }}</h4>
                            <a href="{{ route('news.show', $related->id) }}" class="news-more-link">
                                Читать →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>

<style>
.news-detail { margin-bottom: 60px; padding: 0; overflow: hidden; }
.news-header-detail { padding: 50px 50px 30px; border-bottom: 1px solid var(--gray-medium); }
.news-meta-detail { display: flex; align-items: center; gap: 20px; color: var(--text-muted); font-size: 0.95rem; margin-top: 15px; }
.meta-item { display: flex; align-items: center; gap: 8px; }
.meta-separator { color: var(--gray-medium); }
.news-image-detail { width: 100%; max-height: 500px; overflow: hidden; }
.full-width-image { width: 100%; height: 100%; object-fit: cover; }
.news-content-detail { padding: 50px; font-size: 1.15rem; line-height: 1.8; color: var(--text-color); }
.news-footer-detail { padding: 30px 50px 50px; border-top: 1px solid var(--gray-medium); }

.prose p { margin-bottom: 1.5rem; }
.prose h2 { font-size: 1.8rem; color: var(--primary-dark); margin: 2rem 0 1rem; }
.prose h3 { font-size: 1.5rem; color: var(--primary-dark); margin: 1.5rem 0 0.8rem; }
.prose ul, .prose ol { margin-bottom: 1.5rem; padding-left: 1.5rem; }
.prose li { margin-bottom: 0.5rem; }
.prose blockquote { border-left: 4px solid var(--primary-color); padding-left: 20px; font-style: italic; color: var(--text-muted); margin: 2rem 0; }

.news-card-mini .card-image-wrapper { height: 160px; }
.news-date-mini { font-size: 0.8rem; color: var(--primary-color); font-weight: 600; margin-bottom: 8px; display: block; }
.card-title-mini { font-size: 1.1rem; color: var(--primary-dark); margin-bottom: 15px; line-height: 1.4; height: 3rem; overflow: hidden; }
.news-placeholder-mini { width: 100%; height: 100%; background-color: var(--gray-medium); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--white); }

@media (max-width: 768px) {
    .news-header-detail, .news-content-detail, .news-footer-detail { padding: 25px; }
    .news-meta-detail { flex-direction: column; align-items: flex-start; gap: 10px; }
    .meta-separator { display: none; }
}
</style>
@endsection

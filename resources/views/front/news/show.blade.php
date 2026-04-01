@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-4">{{ $news->title }}</h1>
            <div class="flex items-center text-gray-500 text-sm">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ $news->published_at->format('d.m.Y') }}</span>
                @if($news->title_tatar)
                    <span class="mx-2">•</span>
                    <i class="fas fa-language mr-2"></i>
                    <span>{{ $news->title_tatar }}</span>
                @endif
            </div>
        </div>
        
        <!-- Изображение -->
        @if($news->image)
            <div class="mb-8">
                <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full rounded-lg shadow-md">
            </div>
        @endif
        
        <!-- Контент -->
        <div class="prose max-w-none mb-8">
            {!! $news->content !!}
        </div>
        
        <!-- Кнопка назад -->
        <div class="mt-8 pt-6 border-t">
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-red-600 hover:text-red-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к новостям
            </a>
        </div>
        
        <!-- Похожие новости -->
        @if($relatedNews->count() > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold mb-6">Похожие новости</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedNews as $related)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            @if($related->image)
                                <img src="{{ $related->image }}" alt="{{ $related->title }}" class="w-full h-32 object-cover">
                            @endif
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-1">{{ $related->published_at->format('d.m.Y') }}</p>
                                <h4 class="font-bold mb-2 line-clamp-2">{{ $related->title }}</h4>
                                <a href="{{ route('news.show', $related->id) }}" class="text-red-600 text-sm hover:underline">
                                    Читать →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .prose {
        font-size: 1.125rem;
        line-height: 1.75;
    }
    .prose p {
        margin-bottom: 1.25rem;
    }
    .prose img {
        max-width: 100%;
        height: auto;
        margin: 1.5rem 0;
        border-radius: 0.5rem;
    }
    .prose h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 1.5rem 0 1rem;
    }
    .prose h3 {
        font-size: 1.25rem;
        font-weight: bold;
        margin: 1.25rem 0 0.75rem;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
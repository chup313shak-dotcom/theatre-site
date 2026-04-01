@extends('layouts.app')

@section('title', 'Новости театра')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold mb-8">Новости театра</h1>
    
    @if($news->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    @if($item->image)
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <p class="text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $item->published_at->format('d.m.Y') }}
                        </p>
                        <h2 class="text-xl font-bold mb-3 hover:text-red-600 transition">
                            <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                        </h2>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($item->content), 150) }}
                        </p>
                        <a href="{{ route('news.show', $item->id) }}" 
                           class="inline-block text-red-600 hover:text-red-700 font-semibold">
                            Читать далее <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $news->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Новостей пока нет</p>
        </div>
    @endif
</div>
@endsection
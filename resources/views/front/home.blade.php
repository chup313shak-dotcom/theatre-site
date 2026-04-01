@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="container mx-auto px-4">
    <!-- Hero Slider -->
    <div class="relative h-[500px] rounded-xl overflow-hidden mb-12" x-data="{ slide: 0 }">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black/50 z-10"></div>
            <img src="/images/hero/theatre.jpg" alt="Театр" class="w-full h-full object-cover">
        </div>
        <div class="relative z-20 flex items-center justify-center h-full text-center text-white">
            <div>
                <h1 class="text-5xl font-bold mb-4">Добро пожаловать в театр!</h1>
                <p class="text-xl mb-8">Откройте для себя мир искусства и эмоций</p>
                <a href="{{ route('spectacles.index') }}" class="bg-red-600 px-8 py-3 rounded-full text-lg hover:bg-red-700 transition inline-block">
                    Афиша спектаклей
                </a>
            </div>
        </div>
    </div>
    
    <!-- Ближайшие спектакли -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Ближайшие спектакли</h2>
            <a href="{{ route('spectacles.index') }}" class="text-red-600 hover:underline">Все спектакли →</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($upcomingShows as $spectacle)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                         alt="{{ $spectacle->title }}"
                         class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">{{ $spectacle->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            <i class="fas fa-user mr-1"></i> {{ $spectacle->director }}
                        </p>
                        <p class="text-sm text-gray-600 mb-2">
                            <i class="fas fa-clock mr-1"></i> {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин
                        </p>
                        <p class="text-sm text-gray-600 mb-3">
                            <i class="fas fa-calendar mr-1"></i> 
                            @if($spectacle->shows->first())
                                {{ $spectacle->shows->first()->start_time->format('d.m.Y H:i') }}
                            @else
                                Скоро
                            @endif
                        </p>
                        <a href="{{ route('spectacles.show', $spectacle->id) }}" 
                           class="block text-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Подробнее
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Новости -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Новости театра</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($news as $item)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                    <div class="flex items-start space-x-4">
                        @if($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-24 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-newspaper text-3xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-1">{{ $item->published_at->format('d.m.Y') }}</p>
                            <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                            <a href="{{ route('news.show', $item->id) }}" class="text-red-600 hover:underline text-sm">
                                Читать далее →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Цитата руководителя -->
    <div class="bg-gradient-to-r from-red-900 to-red-800 rounded-xl p-8 text-white text-center">
        <i class="fas fa-quote-left text-4xl opacity-50 mb-4"></i>
        <p class="text-xl italic mb-4">Театр — это не просто место, где показывают спектакли. Это место, где оживают мечты, 
        где каждый зритель становится соучастником волшебства.</p>
        <p class="font-bold">— Художественный руководитель театра</p>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Афиша спектаклей')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold mb-8">Афиша спектаклей</h1>
    
    <!-- Фильтры -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('spectacles.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Поиск</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Название спектакля..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Жанр</label>
                <select name="genre" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Все жанры</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Возраст</label>
                <select name="age" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Любой</option>
                    @foreach($ageLimits as $age)
                        <option value="{{ $age }}" {{ request('age') == $age ? 'selected' : '' }}>
                            {{ $age }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Дата</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="md:col-span-4">
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-search mr-2"></i> Применить фильтры
                </button>
                @if(request()->anyFilled(['search', 'genre', 'age', 'date']))
                    <a href="{{ route('spectacles.index') }}" class="ml-2 text-gray-600 hover:underline">
                        Сбросить фильтры
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Список спектаклей -->
    @if($spectacles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($spectacles as $spectacle)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                    <div class="relative overflow-hidden h-72">
                        <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                             alt="{{ $spectacle->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-sm">
                            {{ $spectacle->age_limit }}
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-xl mb-2">{{ $spectacle->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-user mr-1"></i> {{ $spectacle->director }}
                        </p>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-clock mr-1"></i> {{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин
                        </p>
                        <p class="text-gray-600 text-sm mb-3">
                            <i class="fas fa-star text-yellow-400 mr-1"></i> {{ number_format($spectacle->rating, 1) }} ({{ $spectacle->reviews_count }} отзывов)
                        </p>
                        
                        @if($spectacle->shows->count() > 0)
                            <div class="mb-3">
                                <p class="text-sm font-semibold mb-1">Ближайшие показы:</p>
                                @foreach($spectacle->shows->take(2) as $show)
                                    <p class="text-xs text-gray-500">{{ $show->start_time->format('d.m.Y H:i') }}</p>
                                @endforeach
                            </div>
                        @endif
                        
                        <a href="{{ route('spectacles.show', $spectacle->id) }}" 
                           class="block text-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Купить билет
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $spectacles->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Спектакли не найдены</p>
            <a href="{{ route('spectacles.index') }}" class="text-red-600 hover:underline mt-2 inline-block">
                Сбросить фильтры
            </a>
        </div>
    @endif
</div>
@endsection
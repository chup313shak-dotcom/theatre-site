<!-- resources/views/front/actors/show.blade.php -->
@extends('layouts.app')

@section('title', $actor->name)

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Фото -->
            <div class="p-6">
                @if($actor->photo)
                    <img src="{{ $actor->photo }}" alt="{{ $actor->name }}" class="w-full rounded-lg shadow-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-circle text-8xl text-gray-400"></i>
                    </div>
                @endif
            </div>
            
            <!-- Информация -->
            <div class="md:col-span-2 p-6">
                <h1 class="text-3xl font-bold mb-2">{{ $actor->name }}</h1>
                <p class="text-red-600 font-semibold mb-4">{{ $actor->category }}</p>
                
                <!-- Награды (безопасная обработка) -->
                @php
                    $awards = $actor->awards;
                    if (is_string($awards)) {
                        $awards = json_decode($awards, true);
                    }
                    if (!is_array($awards)) {
                        $awards = [];
                    }
                @endphp
                
                @if(count($awards) > 0)
                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Награды и звания</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($awards as $award)
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">{{ $award }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Биография</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $actor->biography }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Роли в спектаклях текущего сезона -->
    @php
        $currentSeasonRoles = $actor->getCurrentSeasonRoles();
    @endphp
    
    @if($currentSeasonRoles->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Роли в спектаклях текущего сезона</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($currentSeasonRoles as $spectacle)
                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                        <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                             alt="{{ $spectacle->title }}"
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2">{{ $spectacle->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-user mr-1"></i> {{ $spectacle->director }}
                            </p>
                            @if($spectacle->pivot->role)
                                <p class="text-sm text-red-600 mb-3">Роль: {{ $spectacle->pivot->role }}</p>
                            @endif
                            <a href="{{ route('spectacles.show', $spectacle->id) }}" 
                               class="block text-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                Подробнее о спектакле
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
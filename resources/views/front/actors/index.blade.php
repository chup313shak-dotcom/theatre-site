@extends('layouts.app')

@section('title', 'Группа театра')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold mb-8">Группа театра</h1>
    
    <!-- Фильтрация по категориям -->
    <div class="flex flex-wrap gap-3 mb-8">
        <button onclick="filterActors('all')" class="filter-btn active px-4 py-2 rounded-full bg-red-600 text-white">
            Все актеры
        </button>
        @foreach($categories as $category => $actorsList)
            <button onclick="filterActors('{{ $category }}')" class="filter-btn px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 transition">
                {{ $category }}
            </button>
        @endforeach
    </div>
    
    <!-- Список актеров -->
    @foreach($categories as $category => $actorsList)
        <div class="actor-category mb-12" data-category="{{ $category }}">
            <h2 class="text-2xl font-bold mb-6 border-l-4 border-red-600 pl-4">{{ $category }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($actorsList as $actor)
                    <a href="{{ route('actors.show', $actor->id) }}" class="group">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                            <div class="h-64 overflow-hidden">
                                @if($actor->photo)
                                    <img src="{{ $actor->photo }}" alt="{{ $actor->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="font-bold text-lg mb-1 group-hover:text-red-600">{{ $actor->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
function filterActors(category) {
    // Обновляем активную кнопку
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-red-600', 'text-white');
        btn.classList.add('bg-gray-200');
    });
    event.target.classList.remove('bg-gray-200');
    event.target.classList.add('bg-red-600', 'text-white');
    
    // Показываем/скрываем категории
    document.querySelectorAll('.actor-category').forEach(cat => {
        if(category === 'all' || cat.dataset.category === category) {
            cat.style.display = 'block';
        } else {
            cat.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
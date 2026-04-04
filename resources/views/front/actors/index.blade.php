@extends('layouts.app')

@section('title', 'Группа театра')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Группа театра</h1>
        <p class="page-subtitle">Наши талантливые артисты и творческий коллектив</p>
    </div>
    
    <!-- Фильтрация по категориям -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-category="all">
            Все артисты
        </button>
        @foreach($categories as $category => $actorsList)
            <button class="filter-tab" data-category="{{ $category }}">
                {{ $category }}
            </button>
        @endforeach
    </div>
    
    <!-- Список актеров -->
    <div class="actors-container">
        @foreach($categories as $category => $actorsList)
            <section class="actor-category-section" data-category="{{ $category }}">
                <h2 class="category-title">{{ $category }}</h2>
                <div class="card-grid actors-grid">
                    @foreach($actorsList as $actor)
                        <a href="{{ route('actors.show', $actor->id) }}" class="card actor-card">
                            <div class="actor-image-wrapper">
                                @if($actor->photo)
                                    <img src="{{ $actor->photo }}" alt="{{ $actor->name }}" 
                                         class="actor-image">
                                @else
                                    <div class="actor-placeholder">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <h3 class="actor-name">{{ $actor->name }}</h3>
                                <p class="actor-role">{{ $category }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        const category = tab.dataset.category;
        
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        
        // Filter sections
        document.querySelectorAll('.actor-category-section').forEach(section => {
            if (category === 'all' || section.dataset.category === category) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection
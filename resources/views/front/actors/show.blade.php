<!-- resources/views/front/actors/show.blade.php -->
@extends('layouts.app')

@section('title', $actor->name)

@section('content')
<div class="container">
    <div class="detail-container card">
        <div class="detail-content-wrapper">
            <!-- Фото -->
            <div class="detail-image-box">
                @if($actor->photo)
                    <img src="{{ $actor->photo }}" alt="{{ $actor->name }}" class="detail-image">
                @else
                    <div class="actor-placeholder detail-image">
                        <i class="fas fa-user-circle"></i>
                    </div>
                @endif
            </div>
            
            <!-- Информация -->
            <div class="detail-content">
                <h1 class="page-title text-left">{{ $actor->name }}</h1>
                <p class="actor-category-badge">{{ $actor->category }}</p>
                
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
                    <div class="awards-section">
                        <h3 class="section-subtitle">Награды и звания</h3>
                        <div class="awards-list">
                            @foreach($awards as $award)
                                <span class="award-tag"><i class="fas fa-medal"></i> {{ $award }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="biography-section">
                    <h3 class="section-subtitle">Биография</h3>
                    <p class="description-text">{{ $actor->biography }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Роли в спектаклях текущего сезона -->
    @php
        $currentSeasonRoles = $actor->getCurrentSeasonRoles();
    @endphp
    
    @if($currentSeasonRoles->count() > 0)
        <div class="section">
            <h2 class="section-title">Роли в спектаклях текущего сезона</h2>
            <div class="card-grid">
                @foreach($currentSeasonRoles as $spectacle)
                    <div class="card spectacle-card">
                        <div class="card-image-wrapper">
                            <img src="{{ $spectacle->poster ?? '/images/default-poster.jpg' }}" 
                                 alt="{{ $spectacle->title }}"
                                 class="card-image">
                            @if($spectacle->pivot->role)
                                <div class="card-badge">{{ $spectacle->pivot->role }}</div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{ $spectacle->title }}</h3>
                            <div class="card-info">
                                <p class="info-item">
                                    <i class="fas fa-user-tie"></i> <strong>Режиссер:</strong> {{ $spectacle->director }}
                                </p>
                            </div>
                            <a href="{{ route('spectacles.show', $spectacle->id) }}" 
                               class="btn btn-outline card-btn">
                                Подробнее
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
.detail-container { margin-bottom: 50px; padding: 0; overflow: hidden; }
.detail-content-wrapper { display: flex; flex-direction: row; }
.detail-image-box { width: 40%; flex-shrink: 0; background-color: var(--gray-medium); }
.detail-image { width: 100%; height: 100%; object-fit: cover; }
.detail-content { padding: 40px; flex: 1; }
.actor-category-badge { display: inline-block; padding: 5px 15px; background-color: var(--primary-light); color: var(--primary-dark); border-radius: 20px; font-weight: 700; font-size: 0.9rem; margin-bottom: 25px; }
.section-subtitle { font-size: 1.25rem; color: var(--primary-dark); margin-bottom: 15px; border-bottom: 2px solid var(--primary-light); padding-bottom: 5px; margin-top: 30px; }
.awards-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px; }
.award-tag { padding: 8px 15px; background-color: var(--white); border: 1px solid var(--accent-color); color: var(--primary-dark); border-radius: 8px; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
.award-tag i { color: #ffc107; }
.biography-section { margin-top: 30px; }
.description-text { color: var(--text-color); line-height: 1.8; white-space: pre-line; }
.spectacle-card .card-title { font-size: 1.3rem; min-height: 3rem; display: flex; align-items: center; }

@media (max-width: 768px) {
    .detail-content-wrapper { flex-direction: column; }
    .detail-image-box { width: 100%; height: 400px; }
}
</style>
@endsection

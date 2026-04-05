<!-- resources/views/front/actors/show.blade.php -->
@extends('layouts.app')

@section('title', $actor->name)

@section('content')
<div class="container py-10">
    <div class="actor-detail-card card overflow-hidden mb-16">
        <div class="actor-flex-wrapper">
            <!-- Фото артиста -->
            <div class="actor-photo-side">
                @if($actor->photo)
                    <div class="photo-container">
                        <img src="{{ asset($actor->photo) }}" alt="{{ $actor->name }}" class="actor-main-img">
                        <div class="photo-overlay"></div>
                    </div>
                @else
                    <div class="actor-placeholder-large">
                        <i class="fas fa-user-tie fa-5x"></i>
                    </div>
                @endif
            </div>
            
            <!-- Информация -->
            <div class="actor-info-side p-10">
                <div class="actor-header mb-8">
                    <h1 class="actor-name-title mb-2">{{ $actor->name }}</h1>
                    <span class="actor-role-badge">{{ $actor->category ?? 'Артист' }}</span>
                </div>
                
                @php
                    $awards = $actor->awards;
                    if (is_string($awards)) { $awards = json_decode($awards, true); }
                    if (!is_array($awards)) { $awards = []; }
                @endphp
                
                @if(count($awards) > 0)
                    <div class="actor-section mb-10">
                        <h3 class="actor-section-title mb-4">Награды и звания</h3>
                        <div class="awards-grid">
                            @foreach($awards as $award)
                                <div class="award-item">
                                    <div class="award-icon"><i class="fas fa-award"></i></div>
                                    <div class="award-text">{{ $award }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @if($actor->biography)
                    <div class="actor-section">
                        <h3 class="actor-section-title mb-4">Биография</h3>
                        <div class="biography-text">
                            {!! nl2br(e($actor->biography)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @php $currentSeasonRoles = $actor->getCurrentSeasonRoles(); @endphp
    
    @if($currentSeasonRoles->count() > 0)
        <section class="actor-roles-section">
            <div class="section-header mb-8">
                <h2 class="section-title">Роли в спектаклях</h2>
            </div>
            
            <div class="card-grid">
                @foreach($currentSeasonRoles as $spectacle)
                    <div class="card spectacle-card-mini">
                        <div class="card-image-wrapper">
                            <img src="{{ asset($spectacle->poster ?? 'images/posters/default.jpg') }}" 
                                 alt="{{ $spectacle->title }}"
                                 class="card-image">
                            <div class="role-overlay">
                                <span class="role-name">{{ $spectacle->pivot->role ?? 'Роль' }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $spectacle->title }}</h4>
                            <p class="card-info-text">Режиссер: {{ $spectacle->director }}</p>
                            <a href="{{ route('spectacles.show', $spectacle->id) }}" class="btn-link mt-4 d-inline-block">
                                Подробнее <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('styles')
<style>
    .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mb-10 { margin-bottom: 2.5rem; }
    .mb-16 { margin-bottom: 4rem; }
    .p-10 { padding: 2.5rem; }
    .ml-1 { margin-left: 0.25rem; }
    .d-inline-block { display: inline-block; }

    .actor-flex-wrapper { display: flex; min-height: 600px; }
    .actor-photo-side { width: 38%; flex-shrink: 0; position: relative; background-color: var(--primary-dark); }
    .photo-container { height: 100%; width: 100%; overflow: hidden; }
    .actor-main-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .actor-photo-side:hover .actor-main-img { transform: scale(1.05); }
    .photo-overlay { position: absolute; inset: 0; background: linear-gradient(to right, transparent 70%, rgba(0,0,0,0.1)); pointer-events: none; }

    .actor-info-side { flex: 1; background-color: var(--white); }
    .actor-name-title { font-size: 3rem; font-weight: 900; color: var(--primary-dark); line-height: 1.1; }
    .actor-role-badge { display: inline-block; padding: 6px 16px; background-color: var(--primary-light); color: var(--primary-color); border-radius: 50px; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; }

    .actor-section-title { font-size: 1.5rem; color: var(--primary-dark); font-weight: 700; position: relative; padding-bottom: 10px; }
    .actor-section-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background-color: var(--accent-color); }

    .awards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 15px; }
    .award-item { display: flex; align-items: center; gap: 15px; padding: 15px; background-color: var(--gray-light); border-radius: 12px; border: 1px solid var(--border-color); }
    .award-icon { width: 40px; height: 40px; background-color: var(--white); color: #ffc107; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .award-text { font-weight: 600; font-size: 0.95rem; color: var(--primary-dark); }

    .biography-text { font-size: 1.1rem; line-height: 1.8; color: var(--text-muted); }

    .spectacle-card-mini .role-overlay { position: absolute; bottom: 15px; left: 15px; right: 15px; background-color: rgba(0, 71, 171, 0.9); color: white; padding: 8px 15px; border-radius: 6px; font-size: 0.9rem; font-weight: 700; text-align: center; transform: translateY(10px); opacity: 0; transition: var(--transition); }
    .spectacle-card-mini:hover .role-overlay { transform: translateY(0); opacity: 1; }
    .card-info-text { font-size: 0.9rem; color: var(--text-muted); }

    @media (max-width: 992px) {
        .actor-flex-wrapper { flex-direction: column; }
        .actor-photo-side { width: 100%; height: 500px; }
    }
</style>
@endpush

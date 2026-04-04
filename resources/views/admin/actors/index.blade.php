@extends('layouts.admin')

@section('title', 'Артисты')
@section('header', 'Управление труппой')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Список артистов</h3>
        <a href="{{ route('admin.actors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить артиста
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th width="80">Фото</th>
                        <th>Имя</th>
                        <th>Категория</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actors as $actor)
                        <tr>
                            <td>
                                <div class="admin-table-img">
                                    @php
                                        $photoUrl = asset('images/default-actor.jpg');
                                        if ($actor->photo) {
                                            if (str_starts_with($actor->photo, 'http')) {
                                                $photoUrl = $actor->photo;
                                            } else {
                                                // Убираем лишние слэши в начале и проверяем существование
                                                $cleanPath = ltrim($actor->photo, '/');
                                                if (file_exists(public_path($cleanPath))) {
                                                    $photoUrl = asset($cleanPath);
                                                } elseif (file_exists(public_path('images/actors/' . basename($cleanPath)))) {
                                                    $photoUrl = asset('images/actors/' . basename($cleanPath));
                                                } else {
                                                    $photoUrl = asset('storage/' . $cleanPath);
                                                }
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $photoUrl }}" alt="{{ $actor->name }}">
                                </div>
                            </td>
                            <td>
                                <div class="admin-table-title">{{ $actor->name }}</div>
                                <div class="admin-table-subtitle">{{ $actor->name_tatar }}</div>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ $actor->category ?? 'Артист' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.actors.edit', $actor->id) }}" class="action-btn edit-btn" title="Редактировать">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.actors.destroy', $actor->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Вы уверены?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center italic">Артистов пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($actors->hasPages())
        <div class="pagination-container">
            {{ $actors->links() }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Спектакли')
@section('header', 'Управление спектаклями')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Список всех спектаклей</h3>
        <a href="{{ route('admin.spectacles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить спектакль
        </a>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Постер</th>
                    <th>Название</th>
                    <th>Режиссер</th>
                    <th>Длительность</th>
                    <th>Жанр / Возраст</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spectacles as $spectacle)
                    <tr>
                        <td>
                            <div class="admin-table-img">
                                @php
                                    $posterUrl = asset('images/default-poster.jpg');
                                    if ($spectacle->poster) {
                                        if (str_starts_with($spectacle->poster, 'http')) {
                                            $posterUrl = $spectacle->poster;
                                        } else {
                                            $cleanPath = ltrim($spectacle->poster, '/');
                                            if (file_exists(public_path($cleanPath))) {
                                                $posterUrl = asset($cleanPath);
                                            } elseif (str_contains($cleanPath, 'storage/')) {
                                                $posterUrl = asset($cleanPath);
                                            } else {
                                                $posterUrl = asset('storage/' . $cleanPath);
                                            }
                                        }
                                    }
                                @endphp
                                <img src="{{ $posterUrl }}" alt="{{ $spectacle->title }}">
                            </div>
                        </td>
                        <td>
                            <div class="admin-table-title">{{ $spectacle->title }}</div>
                            <div class="admin-table-subtitle">{{ $spectacle->title_tatar }}</div>
                        </td>
                        <td>{{ $spectacle->director }}</td>
                        <td>{{ floor($spectacle->duration / 60) }}ч {{ $spectacle->duration % 60 }}мин</td>
                        <td>
                            <span class="badge badge-primary">{{ $spectacle->genre ?? 'Драма' }}</span>
                            <span class="badge badge-warning">{{ $spectacle->age_limit }}</span>
                        </td>
                        <td class="text-right">
                            <div class="admin-actions">
                                <a href="{{ route('admin.spectacles.edit', $spectacle->id) }}" class="action-btn edit-btn" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.spectacles.destroy', $spectacle->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Вы уверены?')">
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
                        <td colspan="6" class="text-center py-5 text-muted italic">Спектаклей пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($spectacles->hasPages())
        <div class="pagination-container">
            {{ $spectacles->links() }}
        </div>
    @endif
</div>
@endsection

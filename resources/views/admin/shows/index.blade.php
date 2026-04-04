@extends('layouts.admin')

@section('title', 'Афиша')
@section('header', 'Управление афишей')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Список ближайших сеансов</h3>
        <a href="{{ route('admin.shows.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить сеанс
        </a>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Спектакль</th>
                    <th>Дата и время</th>
                    <th>Места</th>
                    <th>Цена (мин)</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shows as $show)
                    <tr>
                        <td>#{{ $show->id }}</td>
                        <td>
                            <div class="admin-table-title">{{ $show->spectacle->title }}</div>
                            <div class="admin-table-subtitle">{{ $show->spectacle->genre }}</div>
                        </td>
                        <td>
                            <div class="show-datetime">
                                <i class="far fa-calendar-alt text-primary"></i> 
                                <strong>{{ $show->start_time->format('d.m.Y') }}</strong>
                                <span class="text-muted ml-2">{{ $show->start_time->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary">Всего: 100</span>
                        </td>
                        <td>{{ number_format($show->base_price ?? 500, 0, '.', ' ') }} ₽</td>
                        <td class="text-right">
                            <div class="admin-actions">
                                <a href="{{ route('admin.shows.edit', $show->id) }}" class="action-btn edit-btn" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.shows.destroy', $show->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Вы уверены?')">
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
                        <td colspan="6" class="text-center py-5 text-muted italic">Сеансов пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($shows->hasPages())
        <div class="pagination-container">
            {{ $shows->links() }}
        </div>
    @endif
</div>

<style>
    .show-datetime i { margin-right: 8px; font-size: 1.1rem; }
</style>
@endsection

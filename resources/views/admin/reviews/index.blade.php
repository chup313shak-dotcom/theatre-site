@extends('layouts.admin')

@section('title', 'Отзывы')
@section('header', 'Управление отзывами')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Список всех отзывов</h3>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Пользователь</th>
                    <th>Спектакль</th>
                    <th>Оценка</th>
                    <th>Текст отзыва</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>#{{ $review->id }}</td>
                        <td>
                            <div class="admin-table-title">{{ $review->user->name ?? $review->author_name }}</div>
                            <div class="admin-table-subtitle">{{ $review->user->email ?? 'Гость' }}</div>
                        </td>
                        <td>
                            <div class="admin-table-title">{{ $review->spectacle->title }}</div>
                        </td>
                        <td>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-gray' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <div class="review-text-cell" title="{{ $review->comment }}">
                                {{ Str::limit($review->comment, 100) }}
                            </div>
                        </td>
                        <td>
                            @if($review->is_approved)
                                <span class="badge badge-success">Опубликован</span>
                            @else
                                <span class="badge badge-warning">На модерации</span>
                            @endif
                        </td>
                        <td>
                            <div class="admin-table-subtitle">{{ $review->created_at->format('d.m.Y H:i') }}</div>
                        </td>
                        <td class="text-right">
                            <div class="admin-actions">
                                <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button type="submit" class="action-btn {{ $review->is_approved ? 'edit-btn' : 'success-btn' }}" 
                                            title="{{ $review->is_approved ? 'Снять с публикации' : 'Опубликовать' }}">
                                        <i class="fas {{ $review->is_approved ? 'fa-eye-slash' : 'fa-check' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?')">
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
                        <td colspan="8" class="text-center py-5 text-muted italic">Отзывов пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div class="pagination-container">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

<style>
    .text-warning { color: #ffc107; }
    .text-gray { color: #dee2e6; }
    .review-text-cell { max-width: 350px; font-size: 0.9rem; color: var(--text-color); line-height: 1.4; }
    .success-btn { background-color: #e8f5e9; color: #2e7d32; }
    .success-btn:hover { background-color: #2e7d32; color: white; }
    .inline-form { display: inline-block; margin-left: 5px; }
</style>
@endsection

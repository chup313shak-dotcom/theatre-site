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
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Спектакль</th>
                    <th>Оценка</th>
                    <th>Текст отзыва</th>
                    <th>Дата</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>#{{ $review->id }}</td>
                        <td>
                            <div class="admin-table-title">{{ $review->user->name }}</div>
                            <div class="admin-table-subtitle">{{ $review->user->email }}</div>
                        </td>
                        <td>{{ $review->spectacle->title }}</td>
                        <td>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-gray' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <div class="review-text-preview" title="{{ $review->content }}">
                                {{ Str::limit($review->content, 50) }}
                            </div>
                        </td>
                        <td>{{ $review->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-right">
                            <div class="admin-actions">
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
                        <td colspan="7" class="text-center py-5 text-muted italic">Отзывов пока нет</td>
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
    .review-text-preview { max-width: 300px; font-size: 0.9rem; color: var(--text-muted); }
</style>
@endsection

@extends('layouts.admin')

@section('title', 'Новости')
@section('header', 'Управление новостями')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Список новостей</h3>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить новость
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th width="80">Фото</th>
                        <th>Заголовок</th>
                        <th>Дата</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $article)
                        <tr>
                            <td>
                                <div class="admin-table-img">
                                    @php
                                        $imageUrl = asset('images/default-news.jpg');
                                        if ($article->image) {
                                            if (str_starts_with($article->image, 'http')) {
                                                $imageUrl = $article->image;
                                            } else {
                                                $cleanPath = ltrim($article->image, '/');
                                                if (file_exists(public_path($cleanPath))) {
                                                    $imageUrl = asset($cleanPath);
                                                } elseif (str_contains($cleanPath, 'storage/')) {
                                                    $imageUrl = asset($cleanPath);
                                                } else {
                                                    $imageUrl = asset('storage/' . $cleanPath);
                                                }
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $article->title }}">
                                </div>
                            </td>
                            <td>
                                <div class="admin-table-title">{{ $article->title }}</div>
                                <div class="admin-table-subtitle">{{ Str::limit($article->excerpt, 60) }}</div>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ $article->published_at ? $article->published_at->format('d.m.Y') : 'Черновик' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.news.edit', $article->id) }}" class="action-btn edit-btn" title="Редактировать">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Вы уверены?')">
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
                            <td colspan="4" class="text-center italic">Новостей пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($news->hasPages())
        <div class="pagination-container">
            {{ $news->links() }}
        </div>
    @endif
</div>
@endsection

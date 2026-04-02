@extends('layouts.admin')

@section('title', 'Опубликовать новость')
@section('header', 'Новая новость')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Заголовок (RU)</label>
                        <input type="text" name="title" required value="{{ old('title') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Заголовок (TAT)</label>
                        <input type="text" name="title_tatar" value="{{ old('title_tatar') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Изображение</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Дата публикации</label>
                        <input type="date" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Текст новости</label>
                    <textarea name="content" rows="10" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">{{ old('content') }}</textarea>
                </div>

                <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="is_published" id="is_published" value="1" checked
                           class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="is_published" class="text-sm font-bold text-gray-700 cursor-pointer">Опубликовать сразу</label>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.news.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition">Отмена</a>
                <button type="submit" class="bg-red-600 text-white px-8 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                    Опубликовать
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
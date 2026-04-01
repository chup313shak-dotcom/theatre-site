<!-- resources/views/front/profile/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Редактировать профиль')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Редактировать профиль</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Боковое меню -->
            <div class="md:col-span-1">
                @include('front.profile.partials.sidebar')
            </div>
            
            <!-- Форма редактирования -->
            <div class="md:col-span-3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Имя</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Телефон</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_subscribed" value="1" 
                                       {{ $user->is_subscribed ? 'checked' : '' }}
                                       class="mr-2">
                                <span class="text-gray-700">Получать новости и анонсы на email</span>
                            </label>
                        </div>
                        
                        <hr class="my-6">
                        
                        <h3 class="font-bold text-lg mb-4">Смена пароля</h3>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Текущий пароль</label>
                            <input type="password" name="current_password" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Новый пароль</label>
                            <input type="password" name="new_password" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Подтвердите новый пароль</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                Сохранить изменения
                            </button>
                            <a href="{{ route('profile') }}" class="text-gray-600 hover:text-gray-800">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
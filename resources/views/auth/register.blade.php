<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-center mb-6">Регистрация</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register.attempt') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Имя</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Телефон</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Пароль</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                Зарегистрироваться
            </button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Уже есть аккаунт? 
            <a href="{{ route('login') }}" class="text-red-600 hover:underline">Войти</a>
        </p>
    </div>
</div>
@endsection
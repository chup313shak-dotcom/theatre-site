<!-- resources/views/front/profile/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Редактировать профиль')

@section('content')
<div class="container">
    <div class="">
        <h1 class="">Редактировать профиль</h1>
        
        <div class="">
            <!-- Боковое меню -->
            <div class="">
                @include('front.profile.partials.sidebar')
            </div>
            
            <!-- Форма редактирования -->
            <div class="">
                <div class="">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="">
                            <label class="">Имя</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="@error('name') @enderror">
                            @error('name')
                                <p class="">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="">
                            <label class="">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="@error('email') @enderror">
                            @error('email')
                                <p class="">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="">
                            <label class="">Телефон</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="">
                        </div>
                        
                        <div class="">
                            <label class="">
                                <input type="checkbox" name="is_subscribed" value="1" 
                                       {{ $user->is_subscribed ? 'checked' : '' }}
                                       class="">
                                <span class="">Получать новости и анонсы на email</span>
                            </label>
                        </div>
                        
                        <hr class="">
                        
                        <h3 class="">Смена пароля</h3>
                        
                        <div class="">
                            <label class="">Текущий пароль</label>
                            <input type="password" name="current_password" 
                                   class="@error('current_password') @enderror">
                            @error('current_password')
                                <p class="">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="">
                            <label class="">Новый пароль</label>
                            <input type="password" name="new_password" 
                                   class="">
                        </div>
                        
                        <div class="">
                            <label class="">Подтвердите новый пароль</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="">
                        </div>
                        
                        <div class="">
                            <button type="submit" class="">
                                Сохранить изменения
                            </button>
                            <a href="{{ route('profile') }}" class="">
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
<!-- resources/views/front/profile/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Редактировать профиль')

@section('content')
<div class="container py-10">
    <div class="page-header text-left mb-10">
        <h1 class="page-title">Личный кабинет</h1>
        <p class="page-subtitle">Настройка личных данных и параметров профиля</p>
    </div>
    
    <div class="profile-container">
        <!-- Боковое меню -->
        <div class="profile-sidebar-wrapper">
            @include('front.profile.partials.sidebar')
        </div>
        
        <!-- Основной контент (Форма редактирования) -->
        <div class="profile-content">
            <div class="card p-8">
                <div class="section-header mb-6">
                    <h2 class="section-title">Редактировать профиль</h2>
                </div>
                
                <form method="POST" action="{{ route('profile.update') }}" class="profile-edit-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-grid">
                        <div class="form-group mb-4">
                            <label class="form-label" for="name">Имя</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="form-control @error('name') border-error @enderror" placeholder="Введите ваше имя">
                            @error('name')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="form-label" for="email">Электронная почта</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="form-control @error('email') border-error @enderror" placeholder="example@mail.ru">
                            @error('email')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-6">
                            <label class="form-label" for="phone">Телефон</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="form-control" placeholder="+7 (___) ___-__-__">
                        </div>
                    </div>
                    
                    <div class="form-group mb-8">
                        <label class="checkbox-container">
                            <input type="checkbox" name="is_subscribed" value="1" 
                                   {{ $user->is_subscribed ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="checkbox-text">Получать новости и анонсы на email</span>
                        </label>
                    </div>
                    
                    <div class="divider mb-8"></div>
                    
                    <div class="password-change-section">
                        <h3 class="section-subtitle mb-6">Смена пароля</h3>
                        
                        <div class="form-group mb-4">
                            <label class="form-label" for="current_password">Текущий пароль</label>
                            <input type="password" name="current_password" id="current_password" 
                                   class="form-control @error('current_password') border-error @enderror" placeholder="••••••••">
                            <p class="form-hint">Заполните, только если хотите сменить пароль</p>
                            @error('current_password')
                                <p class="text-error mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group mb-4">
                                <label class="form-label" for="new_password">Новый пароль</label>
                                <input type="password" name="new_password" id="new_password" 
                                       class="form-control" placeholder="Минимум 8 символов">
                            </div>
                            
                            <div class="form-group mb-6">
                                <label class="form-label" for="new_password_confirmation">Подтвердите пароль</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                       class="form-control" placeholder="Повторите новый пароль">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions mt-10">
                        <button type="submit" class="btn btn-primary px-8">
                            <i class="fas fa-save mr-2"></i> Сохранить изменения
                        </button>
                        <a href="{{ route('profile') }}" class="btn btn-outline ml-4 px-8">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mb-10 { margin-bottom: 2.5rem; }
    .mt-10 { margin-top: 2.5rem; }
    .p-8 { padding: 2rem; }
    .mr-2 { margin-right: 0.5rem; }
    .ml-4 { margin-left: 1rem; }
    .px-8 { padding-left: 2rem; padding-right: 2rem; }
    
    .divider { height: 1px; background-color: var(--gray-medium); }
    .section-subtitle { font-size: 1.4rem; color: var(--primary-dark); font-weight: 700; }
    .form-hint { font-size: 0.85rem; color: var(--text-muted); margin-top: 5px; }
    .text-error { color: var(--error-color); }
    .border-error { border-color: var(--error-color) !important; }
    
    /* Grid for desktop */
    @media (min-width: 768px) {
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    }
    
    /* Custom Checkbox */
    .checkbox-container {
        display: block;
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        font-size: 1rem;
        user-select: none;
    }
    .checkbox-container input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: var(--gray-medium);
        border-radius: 4px;
        transition: var(--transition);
    }
    .checkbox-container:hover input ~ .checkmark { background-color: #ccc; }
    .checkbox-container input:checked ~ .checkmark { background-color: var(--primary-color); }
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 8px;
        top: 4px;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .checkbox-container input:checked ~ .checkmark:after { display: block; }
    .checkbox-text { color: var(--text-color); font-weight: 500; }

    /* Button effects override if needed */
    .btn-outline:hover { background-color: var(--primary-color); color: white; }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Регистрация | Театр имени Аяза Гилязова')

@section('content')
<div class="container">
    <div class="auth-container">
        <h1 class="auth-title">Создать аккаунт</h1>
        
        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register.attempt') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Ваше имя</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="form-control" placeholder="Иван Иванов">
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="form-control" placeholder="example@mail.ru">
            </div>
            
            <div class="form-group">
                <label class="form-label">Телефон</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       class="form-control" placeholder="+7 (999) 000-00-00">
            </div>
            
            <div class="form-group">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" required
                       class="form-control" placeholder="Минимум 8 символов">
            </div>
            
            <div class="form-group">
                <label class="form-label">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" required
                       class="form-control" placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">
                Зарегистрироваться
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="auth-link">Войти в кабинет</a></p>
        </div>
    </div>
</div>

<style>
    .auth-link {
        color: var(--primary-color);
        font-weight: 600;
    }
    .auth-link:hover {
        text-decoration: underline;
    }
    /* Дополнительные отступы для формы регистрации */
    .auth-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>
@endsection

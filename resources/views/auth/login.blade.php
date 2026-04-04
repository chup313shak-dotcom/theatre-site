@extends('layouts.app')

@section('title', 'Вход | Театр имени Аяза Гилязова')

@section('content')
<div class="container">
    <div class="auth-container">
        <h1 class="auth-title">Вход в личный кабинет</h1>
        
        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login.attempt') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="form-control" placeholder="example@mail.ru">
            </div>
            
            <div class="form-group">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" required
                       class="form-control" placeholder="••••••••">
            </div>
            
            <div class="form-group auth-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Запомнить меня</span>
                </label>
                <a href="#" class="forgot-password">Забыли пароль?</a>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">
                Войти
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Нет аккаунта? <a href="{{ route('register') }}" class="auth-link">Зарегистрироваться</a></p>
        </div>
    </div>
</div>

<style>
    .auth-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        cursor: pointer;
    }
    .forgot-password, .auth-link {
        color: var(--primary-color);
        font-weight: 600;
    }
    .forgot-password:hover, .auth-link:hover {
        text-decoration: underline;
    }
</style>
@endsection

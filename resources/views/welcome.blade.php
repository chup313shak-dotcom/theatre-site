@extends('layouts.app')

@section('title', 'Добро пожаловать | Театр имени Аяза Гилязова')

@section('content')
<div class="container">
    <div class="welcome-section">
        <h1>Театр имени Аяза Гилязова</h1>
        <p>Добро пожаловать на наш сайт. Здесь вы можете ознакомиться с афишей, нашими артистами и последними новостями.</p>
        
        <div class="actions">
            <a href="{{ route('spectacles.index') }}" class="btn btn-primary">Афиша</a>
            <a href="{{ route('news.index') }}" class="btn">Новости</a>
        </div>
    </div>
</div>

<style>
    .welcome-section {
        padding: 50px 0;
        text-align: center;
    }
    .welcome-section h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }
    .welcome-section p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 30px;
    }
    .btn {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        border: 1px solid #ccc;
        color: #333;
        transition: all 0.3s;
    }
    .btn-primary {
        background-color: #0047ab;
        color: white;
        border-color: #0047ab;
    }
    .btn:hover {
        opacity: 0.8;
    }
</style>
@endsection

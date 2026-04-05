@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="container py-10">
    <!-- Page Header -->
    <header class="page-header">
        <h1 class="page-title">Контакты</h1>
        <p class="page-subtitle">Набережночелнинский государственный татарский драматический театр имени Аяза Гилязова</p>
    </header>

    <div class="contacts-grid">
        <!-- Contact Info -->
        <div class="contacts-info">
            <div class="contact-card card p-8 mb-6">
                <div class="contact-item mb-8">
                    <div class="contact-icon bg-primary-light text-primary">
                        <i class="fas fa-location-dot"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Адрес</h3>
                        <p>Набережные Челны, ЗЯБ, Низаметдинова, 29</p>
                    </div>
                </div>

                <div class="contact-item mb-8">
                    <div class="contact-icon bg-primary-light text-primary">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Касса</h3>
                        <p><a href="tel:+78552253177" class="hover-underline">+7 (8552) 25‒31‒77</a></p>
                    </div>
                </div>

                <div class="contact-item mb-8">
                    <div class="contact-icon bg-primary-light text-primary">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Приёмная</h3>
                        <p><a href="mailto:gilyazov_theatre@mail.ru" class="hover-underline">gilyazov_theatre@mail.ru</a></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon bg-primary-light text-primary">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Режим работы</h3>
                        <p>Ежедневно с 10:00 до 19:00</p>
                    </div>
                </div>
            </div>

            <div class="social-box p-6 card text-center">
                <h3 class="mb-4">Мы в социальных сетях</h3>
                <div class="social-links-large">
                    <a href="#" class="social-btn vk"><i class="fab fa-vk"></i></a>
                    <a href="#" class="social-btn telegram"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="social-btn youtube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="contacts-map card overflow-hidden">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Af796695689128f64240742f9e429188a8d11e51b6378413b86022e3e2c36696b&amp;source=constructor" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .p-8 { padding: 2rem; }
    .p-6 { padding: 1.5rem; }
    
    .contacts-grid {
        display: grid;
        grid-template-columns: 400px 1fr;
        gap: 30px;
        min-height: 500px;
    }

    .contact-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .contact-text h3 {
        font-size: 1.1rem;
        margin-bottom: 5px;
        color: var(--primary-dark);
        font-weight: 700;
    }

    .contact-text p {
        color: var(--text-muted);
        font-size: 1rem;
        line-height: 1.4;
    }

    .hover-underline:hover {
        text-decoration: underline;
        color: var(--primary-color);
    }

    .contacts-map {
        min-height: 500px;
        border-radius: 12px;
    }

    .social-links-large {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .social-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--white);
        transition: var(--transition);
    }

    .social-btn.vk { background-color: #0077ff; }
    .social-btn.telegram { background-color: #24a1de; }
    .social-btn.youtube { background-color: #ff0000; }

    .social-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        opacity: 0.9;
    }

    @media (max-width: 992px) {
        .contacts-grid {
            grid-template-columns: 1fr;
        }
        .contacts-map {
            height: 400px;
        }
    }
</style>
@endpush

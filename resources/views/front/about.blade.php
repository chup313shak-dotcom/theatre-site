@extends('layouts.app')

@section('title', 'О театре')

@section('content')
<div class="container py-10">
    <!-- Page Header -->
    <header class="page-header">
        <h1 class="page-title">О театре</h1>
        <p class="page-subtitle">Набережночелнинский государственный татарский драматический театр имени Аяза Гилязова</p>
    </header>

    <!-- General Info Section -->
    <section class="section">
        <div class="about-preview-grid">
            <div class="about-preview-image" style="background-image: url('{{ asset('images/hero/theatre.jpg') }}');"></div>
            <div class="about-preview-content">
                <p class="about-text">
                    Набережночелнинский государственный татарский драматический театр имени Аяза Гилязова является одним из молодых театральных коллективов Республики Татарстан. Творческий путь театра начался 21 декабря 1990 года спектаклем Р.Батуллы «Возвратится бабочкой душа» («Күбәләк булып җаның кайтыр»), поставленный заслуженным деятелем искусств РТ Фаилем Ибрагимовым.
                </p>
                <p class="about-text">
                    2020 год для театра стал особенно значимым: в этом году драмтеатр отмечал своё тридцатилетие, получив в подарок новое здание, в котором 9 сентября состоялось новоселье. Официальное открытие нового сезона состоялось 14 ноября 2020 года премьерой комедии «Туйга ничә көн кала…» («Свободная черта») И. Зайниева.
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="card-body bg-gray-light rounded-xl p-8 mb-10">
            <p class="about-text mb-4">
                В новое здание театр переехал с новым именем — получил имя заслуженного деятеля искусств ТАССР, татарского прозаика, драматурга <strong>Аяза Гилязова</strong>.
            </p>
            <p class="about-text mb-4">
                Здесь все оснащено по последнему слову техники. Театр стал доступен и для людей с ограниченными возможностями здоровья.
            </p>
            <p class="about-text">
                Зрительный зал включает <strong>278 мест</strong>, есть и балкон. Для актёров созданы все условия: в гримерках удобные стулья, шкафчики для одежды, большие зеркала с подсветкой и все необходимое для быта…
            </p>
        </div>

        <div class="about-cards-grid mb-10">
            <div class="card p-6 text-center highlight-card">
                <i class="fas fa-couch fa-3x mb-4 text-primary"></i>
                <h3 class="card-title">Основной зал</h3>
                <p class="text-muted">278 мест, балкон и современное оборудование</p>
            </div>
            <div class="card p-6 text-center">
                <i class="fas fa-users-viewfinder fa-3x mb-4 text-primary"></i>
                <h3 class="card-title">Малый зал</h3>
                <p class="text-muted">57 мест для камерных постановок</p>
            </div>
            <div class="card p-6 text-center">
                <i class="fas fa-laptop-code fa-3x mb-4 text-primary"></i>
                <h3 class="card-title">Коворкинг</h3>
                <p class="text-muted">Центр для начинающих творческих людей</p>
            </div>
            <div class="card p-6 text-center">
                <i class="fas fa-child-reaching fa-3x mb-4 text-primary"></i>
                <h3 class="card-title">Детская студия</h3>
                <p class="text-muted">Для детей от 7 до 18 лет</p>
            </div>
            <div class="card p-6 text-center">
                <i class="fas fa-masks-theater fa-3x mb-4 text-primary"></i>
                <h3 class="card-title">Репертуар</h3>
                <p class="text-muted">Масштабные классические и современные постановки</p>
            </div>
        </div>

        <div class="about-text">
            <p>В репертуаре есть такие масштабные спектакли, как «Яратылмый калган ярлар» («Любимые, лишённые любви») Б. Салахова; «Ике хуҗаның хезмәтчесе» («Слуга двух господ») К. Гольдони, «Шәһәр.Нокта.Брежнев» Ш.Идиатуллина, «Яшь йөрәкләр» Ф.Бурнаша и др.</p>
        </div>
    </section>

    <!-- History Timeline -->
    <section class="section mt-20">
        <div class="section-header">
            <h2 class="section-title">История</h2>
        </div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">1918</div>
                <div class="timeline-content">
                    <p>В ноябре 1918 года в Набережных Челнах при народном доме (клубе) был организован татарский драматический кружок. В его первый состав входили красноармейцы, прогрессивная часть молодежи. У истоков стояли первые актеры: Н.Гарифуллин, А.Гильфанов, Ф.Гиззатуллин, З.Хасаншин, семья Габитовых. Ставили маленькие пьесы и концертные номера. Женские роли исполняли мужчины.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1923-1924</div>
                <div class="timeline-content">
                    <p>Первой «сценой» кружка стал кинотеатр, переоборудованный в 1923-1924 годах из складов для хранения соли на улице Центральной. Спектакли показывали после киносеанса. Там и был поставлен первый спектакль «Угасшие звезды» по пьесе классика татарской драматургии К.Тинчурина.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1930</div>
                <div class="timeline-content">
                    <p>В тридцатые годы репертуар пополнился пьесами поэтов Нур Баяна и Хади Такташа, драматургов Тази Гиззата и Галиаскара Камала.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1940-1945</div>
                <div class="timeline-content">
                    <p>В годы войны коллектив продолжает показывать свои спектакли, многие артисты уходят на фронт, роли исполняют в основном женщины.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1952</div>
                <div class="timeline-content">
                    <p>В 1952 году татарский драматический коллектив приобретает свою сцену в районном Доме культуры (в пристрое со зрительным залом на 300 мест). Художественный руководитель – Кашапов Мансур Кашапович.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1958</div>
                <div class="timeline-content">
                    <p>В 1958 году драматический коллектив отметил свой 40-летний юбилей с постановкой «Голубая шаль» К. Тинчурина. Спектакль с успехом прошел на сцене Татарского Государческого Академического театра (г. Казань). После спектакля коллектив был награжден Почетной грамотой Президиума Верховного Совета ТАССР.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1962</div>
                <div class="timeline-content">
                    <p>В 1962 году самодеятельному драматическому коллективу присуждается звание и статус Народного театра. Спустя три года он был признан одним из лучших и стал лауреатом Всероссийского смотра народных театров в Кремлевском Дворце съездов (г. Москва).</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1965</div>
                <div class="timeline-content">
                    <p>Зимой в 1965 году театр выступает в Москве на сцене Кремлевского театра со спектаклем “Голубая шаль” (К.Тинчурин) и им открывает Всероссийскую декаду народных театров. Театр постоянно гастролировал по районам Татарии. Зрители с 1946 по 1984 г. посмотрели свыше 120 театральных представлений. Активная творческая деятельность этого народного театра закончилась в 1988 году. Татарский народный театр радовал зрителей ровно 70 лет.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1973</div>
                <div class="timeline-content">
                    <p>В 1973 году в растущем и обновляющемся городе свои двери распахнул новый Дворец культуры «Энергетик». И в мае 1976 года на дверях молодежных общежитий появились объявления с приглашением желающих участвовать в новом самодеятельном татарском театре при ДК. Организатором этого коллектива выступил Илдар Хазиев. В труппу театра вошли люди разных профессий – учителя, рабочие, повара, трактористы, электросварщики и др. Артисты днем работали на стройках города, а вечером выступали на подмостках. Театр рос и развивался. Любителями театрального искусства были созданы разножанровые спектакли. В 1977 году за творческие заслуги коллективу присвоено почетное звание «Народный».</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1990</div>
                <div class="timeline-content">
                    <p>В 1990 году в городе появился профессиональный татарский драматический театр. Организован он был в соответствии с решением исполкома Набережночелнинского горсовета народных депутатов по согласованию с Министерством культуры ТАССР. Первоначально был городским театром под названием «Набережночелнинский татарский театр-студия ТЮЗ». 21 декабря 1990 года на сцене ДК «Энергетик» первой челнинской профессиональной труппой был сыгран спектакль по пьесе Рабита Батуллы «Күбәләк булып җаның кайтыр» («И вернется бабочкой душа твоя»). Это дата и считается днем рождения Набережночелнинского государственного татарского драматического театра.</p>
                    <p>Первым режиссером, организатором молодежного театра стал Фаиль Ибрагимов, первым директором – Гилемхан Мубаракшин. Труппа была сформирована из актеров Мензелинского, Альметьевского татарских драматических театров и Челнинского татарского народного театра. Ориентир спектаклей был в основном на молодежную аудиторию.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1991</div>
                <div class="timeline-content">
                    <p>В 1991 году коллектив театра начал работать в здании бывшего горкома партии по адресу: улица Хасана Туфана, дом 15. В 1990-1995 г. театром руководил директор Мубаракшин Гилемхан Хадиевич.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1996</div>
                <div class="timeline-content">
                    <p>В 1996 году главным режиссером театра назначен Ренат Аюпов.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">1999</div>
                <div class="timeline-content">
                    <p>В 1999 году театр получил статус государственного и новое название – Набережночелнинский государственный татарский драматический театр.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2002</div>
                <div class="timeline-content">
                    <p>В 2002 году главным режиссером театра назначен Фаиль Ибрагимов.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2005</div>
                <div class="timeline-content">
                    <p>1 марта 2005 года при участии первого Президента Татарстана М.Ш.Шаймиева состоялось торжественное открытие здания театра после реконструкции бывшего горкома партии. С 2007 по 2019 г. директором театра был Файзерахманов Рашат Фаесханович.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2007-2014</div>
                <div class="timeline-content">
                    <p>В эти годы в репертуаре театра появились масштабные спектакли, такие как «Банкрот» (Г.Камал), «Бурлак» (М.Гилязов), «Горькие плоды папоротника» (Р.Сабыр), «Три аршина земли» (А.Гилязов). В апреле 2014 года театр со спектаклем «Ветер шумит в тополях» (Ж.Сиблейрас) принял участие в II Международном театральном фестивале, который проходил в городе Ашхабад.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2020</div>
                <div class="timeline-content">
                    <p>В январе 2020 года художественным руководителем театра назначен Киньзягулов Олег Мадиярович.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section mt-20">
        <div class="section-header">
            <h2 class="section-title">Галерея</h2>
        </div>
        
        @php
            // Список ваших фото из папки public/images/gallery/
            $galleryImages = [
                'tatr.jpg',
                'lamp.jpg',
                'zal.webp',
                'big.jpeg',
                'orig.jfif',
                'photo7.jpg'
            ];
        @endphp

        <div class="card-grid">
            @forelse($galleryImages as $image)
                <div class="card overflow-hidden gallery-card">
                    <img src="{{ asset('images/gallery/' . $image) }}" alt="Фото театра" class="gallery-img">
                </div>
            @empty
                {{-- Если фото еще не добавлены, показываем заглушки --}}
                @for($i = 1; $i <= 6; $i++)
                <div class="card overflow-hidden">
                    <div class="bg-gray-medium h-48 flex items-center justify-center text-white">
                        <i class="fas fa-image fa-3x"></i>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
    .mt-20 { margin-top: 5rem; }
    .mb-10 { margin-bottom: 2.5rem; }
    .p-8 { padding: 2rem; }
    .rounded-xl { border-radius: 1rem; }
    .bg-gray-light { background-color: var(--gray-light); }
    .bg-gray-medium { background-color: var(--gray-medium); }
    .text-primary { color: var(--primary-color); }
    .h-48 { height: 12rem; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }

    .about-cards-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
    }

    .about-cards-grid .card {
        flex: 0 1 350px; /* Фиксированная база для одинакового размера */
        min-height: 220px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .highlight-card {
        border: 2px solid var(--primary-light);
    }
    
    /* Timeline styles */
    .timeline {
        position: relative;
        padding: 40px 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 120px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: var(--primary-light);
    }
    .timeline-item {
        display: flex;
        margin-bottom: 40px;
        position: relative;
    }
    .timeline-year {
        width: 100px;
        font-weight: 800;
        color: var(--primary-dark);
        font-size: 1.25rem;
        text-align: right;
        padding-right: 40px;
        flex-shrink: 0;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 116px;
        top: 8px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: var(--primary-color);
        z-index: 1;
    }
    .timeline-content {
        padding-left: 40px;
        flex: 1;
    }
    .timeline-content p {
        margin-bottom: 10px;
    }
    
    @media (max-width: 768px) {
        .timeline::before {
            left: 20px;
        }
        .timeline-item {
            flex-direction: column;
        }
        .timeline-year {
            text-align: left;
            padding-right: 0;
            padding-left: 40px;
            margin-bottom: 10px;
        }
        .timeline-item::after {
            left: 16px;
        }
    }
</style>
@endpush

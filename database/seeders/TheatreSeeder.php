<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spectacle;
use App\Models\Actor;
use App\Models\Show;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class TheatreSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём тестового пользователя
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Тестовый Пользователь',
                'password' => Hash::make('password'),
                'phone' => '+7 (999) 123-45-67',
                'is_subscribed' => true
            ]
        );

        // ========== СПЕКТАКЛИ ==========
        $spectaclesData = [
            [
                'title' => 'Вызывали?',
                'title_tatar' => 'Чакырдыгызмы?',
                'description' => 'Остроумная комедия о современных отношениях, где герои попадают в забавные и неловкие ситуации, пытаясь разобраться в своих чувствах. Спектакль полон неожиданных поворотов и искрометного юмора.',
                'director' => 'Ильгиз Зайниев',
                'duration' => 120,
                'genre' => 'Комедия',
                'age_limit' => '16+',
                'poster' => '/images/posters/vyzyvali.jpg',
                'rating' => 4.7,
                'reviews_count' => 45,
                'is_active' => true
            ],
            [
                'title' => 'Пробка',
                'title_tatar' => 'Тыгын',
                'description' => 'Комедия о том, как обычная дорожная пробка может изменить судьбы нескольких человек. Неожиданные встречи, откровенные разговоры и смешные ситуации в замкнутом пространстве автомобиля.',
                'director' => 'Радик Бариев',
                'duration' => 110,
                'genre' => 'Комедия',
                'age_limit' => '16+',
                'poster' => '/images/posters/probka.jpg',
                'rating' => 4.5,
                'reviews_count' => 38,
                'is_active' => true
            ],
            [
                'title' => 'Олень',
                'title_tatar' => 'Болан',
                'description' => 'Пронзительная драма о человеческой жестокости и сострадании. История о том, как в трудных жизненных обстоятельствах раскрываются истинные черты характера человека.',
                'director' => 'Айрат Абушахманов',
                'duration' => 130,
                'genre' => 'Драма',
                'age_limit' => '12+',
                'poster' => '/images/posters/olen.jpg',
                'rating' => 4.8,
                'reviews_count' => 52,
                'is_active' => true
            ],
            [
                'title' => 'Любовница',
                'title_tatar' => 'Яраткан хатын',
                'description' => 'Трогательная мелодрама о любви, выборе и женском счастье. Героиня оказывается в сложной ситуации между долгом и чувствами. Спектакль заставляет задуматься о настоящих ценностях.',
                'director' => 'Туфан Минуллин',
                'duration' => 125,
                'genre' => 'Мелодрама',
                'age_limit' => '12+',
                'poster' => '/images/posters/lubovnica.jpg',
                'rating' => 4.6,
                'reviews_count' => 41,
                'is_active' => true
            ],
            [
                'title' => 'Молодые сердца',
                'title_tatar' => 'Яшь йөрәкләр',
                'description' => 'Яркая музыкальная комедия о первой любви, дружбе и мечтах. Герои учатся понимать себя и окружающих, проходят через испытания и находят своё счастье.',
                'director' => 'Радик Бариев',
                'duration' => 115,
                'genre' => 'Музыкальная комедия',
                'age_limit' => '12+',
                'poster' => '/images/posters/molodye-serdca.jpg',
                'rating' => 4.9,
                'reviews_count' => 67,
                'is_active' => true
            ],
            [
                'title' => 'Су анасы',
                'title_tatar' => 'Су анасы',
                'description' => 'Волшебная сказка по мотивам татарского фольклора о таинственной водяной, которая меняет жизнь простого крестьянина. Захватывающая история о любви, предательстве и волшебстве.',
                'director' => 'Туфан Минуллин',
                'duration' => 90,
                'genre' => 'Сказка',
                'age_limit' => '6+',
                'poster' => '/images/posters/su-anasy.jpg',
                'rating' => 4.8,
                'reviews_count' => 45,
                'is_active' => true
            ],
            [
                'title' => 'Әниләр һәм бәбиләр',
                'title_tatar' => 'Әниләр һәм бәбиләр',
                'description' => 'Трогательная история о материнской любви, семейных ценностях и связи поколений. Спектакль, который заставляет задуматься о самом важном в жизни.',
                'director' => 'Радик Бариев',
                'duration' => 120,
                'genre' => 'Драма',
                'age_limit' => '12+',
                'poster' => '/images/posters/aniler.jpg',
                'rating' => 4.9,
                'reviews_count' => 78,
                'is_active' => true
            ],
            [
                'title' => 'Ак калфак',
                'title_tatar' => 'Ак калфак',
                'description' => 'Романтическая история о любви, долге и национальных традициях. Классическая пьеса, которая уже много лет остается в репертуаре театра.',
                'director' => 'Карим Тинчурин',
                'duration' => 150,
                'genre' => 'Драма',
                'age_limit' => '12+',
                'poster' => '/images/posters/ak-kalfak.jpg',
                'rating' => 4.7,
                'reviews_count' => 92,
                'is_active' => true
            ]
        ];

        foreach ($spectaclesData as $data) {
            Spectacle::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }

        // ========== АКТЁРЫ ==========
        $actorsData = [
            [
                'name' => 'Ильнур Гарифуллин',
                'name_tatar' => 'Ильнур Гарифуллин',
                'biography' => 'Народный артист Республики Татарстан. Окончил Казанское театральное училище. В театре с 1995 года. Исполняет главные роли в спектаклях. Лауреат Государственной премии им. Г.Тукая.',
                'category' => 'Народный артист',
                'photo' => '/images/actors/ilnur.jpg',
                'awards' => json_encode(['Государственная премия им. Г.Тукая', 'Заслуженный артист РТ'])
            ],
            [
                'name' => 'Гульшат Гайсина',
                'name_tatar' => 'Гөлшат Гайсина',
                'biography' => 'Заслуженная артистка Республики Татарстан. Окончила Казанскую государственную консерваторию. Обладательница премии "Тантана". Создает яркие, запоминающиеся образы на сцене.',
                'category' => 'Заслуженный артист',
                'photo' => '/images/actors/gulshat.jpg',
                'awards' => json_encode(['Премия "Тантана"', 'Заслуженный артист РТ'])
            ],
            [
                'name' => 'Айдар Сафин',
                'name_tatar' => 'Айдар Сафин',
                'biography' => 'Молодой талантливый актер, выпускник Казанского театрального училища. Лауреат молодежной премии "Новая волна". Обладает широким творческим диапазоном.',
                'category' => 'Артист',
                'photo' => '/images/actors/aydar.jpg',
                'awards' => json_encode(['Молодежная премия "Новая волна"'])
            ],
            [
                'name' => 'Ляйсан Файзуллина',
                'name_tatar' => 'Ләйсән Фәйзуллина',
                'biography' => 'Заслуженная артистка Республики Татарстан. Играет как драматические, так и комедийные роли. Особенно удаются ей лирические и романтические образы.',
                'category' => 'Заслуженный артист',
                'photo' => '/images/actors/lyaysan.jpg',
                'awards' => json_encode(['Заслуженный артист РТ', 'Премия "Идел-йорт"'])
            ],
            [
                'name' => 'Рамиль Салимов',
                'name_tatar' => 'Рамил Салимов',
                'biography' => 'Артист театра и кино. Лауреат многих театральных фестивалей. Играет главные роли в спектаклях текущего репертуара.',
                'category' => 'Артист',
                'photo' => '/images/actors/ramil.jpg',
                'awards' => json_encode(['Лауреат фестиваля "Науруз"'])
            ],
            [
                'name' => 'Наиля Гарипова',
                'name_tatar' => 'Наилә Гарипова',
                'biography' => 'Народная артистка Республики Татарстан. Более 30 лет на сцене, сыграла более 100 ролей. Легенда татарского театра.',
                'category' => 'Народный артист',
                'photo' => '/images/actors/nailya.jpg',
                'awards' => json_encode(['Народный артист РТ', 'Орден "Дуслык"', 'Государственная премия им. Г.Тукая'])
            ],
            [
                'name' => 'Альберт Салихов',
                'name_tatar' => 'Альберт Салихов',
                'biography' => 'Заслуженный артист Республики Татарстан. Мастер сцены, одинаково успешно играет в драме и комедии.',
                'category' => 'Заслуженный артист',
                'photo' => '/images/actors/albert.jpg',
                'awards' => json_encode(['Заслуженный артист РТ'])
            ],
            [
                'name' => 'Зульфия Закирова',
                'name_tatar' => 'Зөлфия Закирова',
                'biography' => 'Молодая актриса, выпускница Казанского театрального училища. Обладает яркой внешностью и талантом. Быстро завоевала любовь зрителей.',
                'category' => 'Артист',
                'photo' => '/images/actors/zulfiya.jpg',
                'awards' => json_encode([])
            ]
        ];

        foreach ($actorsData as $data) {
            Actor::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // Связываем актеров со спектаклями
        $spectacles = Spectacle::all();
        $actors = Actor::all();

        $rolesMapping = [
            'Вызывали?' => [
                'Ильнур Гарифуллин' => 'Главная роль',
                'Гульшат Гайсина' => 'Главная роль',
                'Айдар Сафин' => 'Вторая роль',
                'Рамиль Салимов' => 'Эпизодическая роль'
            ],
            'Пробка' => [
                'Ильнур Гарифуллин' => 'Водитель',
                'Ляйсан Файзуллина' => 'Пассажирка',
                'Альберт Салихов' => 'Второй водитель'
            ],
            'Олень' => [
                'Наиля Гарипова' => 'Мать',
                'Рамиль Салимов' => 'Сын',
                'Зульфия Закирова' => 'Дочь'
            ],
            'Любовница' => [
                'Гульшат Гайсина' => 'Любовница',
                'Ильнур Гарифуллин' => 'Муж',
                'Ляйсан Файзуллина' => 'Жена'
            ],
            'Молодые сердца' => [
                'Айдар Сафин' => 'Молодой человек',
                'Зульфия Закирова' => 'Девушка',
                'Рамиль Салимов' => 'Друг'
            ],
            'Су анасы' => [
                'Гульшат Гайсина' => 'Су анасы',
                'Ильнур Гарифуллин' => 'Крестьянин',
                'Айдар Сафин' => 'Сын'
            ],
            'Әниләр һәм бәбиләр' => [
                'Наиля Гарипова' => 'Әни',
                'Альберт Салихов' => 'Атай',
                'Зульфия Закирова' => 'Кыз'
            ],
            'Ак калфак' => [
                'Ильнур Гарифуллин' => 'Главная роль',
                'Ляйсан Файзуллина' => 'Главная роль',
                'Наиля Гарипова' => 'Вторая роль'
            ]
        ];

        foreach ($spectacles as $spectacle) {
            $roles = $rolesMapping[$spectacle->title] ?? [];
            foreach ($roles as $actorName => $role) {
                $actor = $actors->where('name', $actorName)->first();
                if ($actor && !$spectacle->actors()->where('actor_id', $actor->id)->exists()) {
                    $spectacle->actors()->attach($actor->id, ['role' => $role]);
                }
            }
        }

        // ========== ПОКАЗЫ СПЕКТАКЛЕЙ (СХЕМА ЗАЛА И ЦЕНЫ) ==========
        $hallSchema = [
            'rows' => [
                ['row' => '1', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 20))],
                ['row' => '2', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 20))],
                ['row' => '3', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 18))],
                ['row' => '4', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 18))],
                ['row' => '5', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 16))],
                ['row' => '6', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 16))],
                ['row' => '7', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 14))],
                ['row' => '8', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 14))],
                ['row' => '9', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 12))],
                ['row' => '10', 'seats' => array_map(fn($i) => ['number' => $i, 'status' => 'available'], range(1, 12))],
            ]
        ];

        $prices = [
            'vip' => ['rows' => ['from' => 1, 'to' => 3], 'price' => 1500],
            'standard' => ['rows' => ['from' => 4, 'to' => 7], 'price' => 1000],
            'economy' => ['rows' => ['from' => 8, 'to' => 10], 'price' => 600],
            'default' => ['price' => 500]
        ];

        $startDate = Carbon::now()->addDays(3);

        foreach ($spectacles as $spectacle) {
            // Добавляем показы на ближайшие даты
            for ($i = 0; $i < 4; $i++) {
                $showDate = $startDate->copy()->addDays($i * 2);
                $startTime = $showDate->setTime(18, 30);
                
                Show::firstOrCreate(
                    [
                        'spectacle_id' => $spectacle->id,
                        'start_time' => $startTime
                    ],
                    [
                        'end_time' => $startTime->copy()->addMinutes($spectacle->duration),
                        'prices' => $prices,
                        'hall_schema' => $hallSchema,
                        'is_active' => true
                    ]
                );
            }
            
            // Утренние показы для детских спектаклей
            if (in_array($spectacle->genre, ['Сказка', 'Детский'])) {
                $showDate = $startDate->copy()->addDays(7);
                $startTime = $showDate->setTime(11, 0);
                
                Show::firstOrCreate(
                    [
                        'spectacle_id' => $spectacle->id,
                        'start_time' => $startTime
                    ],
                    [
                        'end_time' => $startTime->copy()->addMinutes($spectacle->duration),
                        'prices' => $prices,
                        'hall_schema' => $hallSchema,
                        'is_active' => true
                    ]
                );
            }
        }

        // ========== НОВОСТИ ==========
        $newsData = [
            [
                'title' => 'Премьера сезона! Спектакль "Вызывали?"',
                'title_tatar' => 'Премьера сезона! "Чакырдыгызмы?" спектакле',
                'content' => '<p>Дорогие зрители! Рады сообщить о долгожданной премьере этого сезона - комедии "Вызывали?" в постановке Ильгиза Зайниева.</p><p>Это остроумная и современная история о любви, дружбе и неожиданных поворотах судьбы. В спектакле заняты ведущие актеры театра.</p><p><strong>Ждем вас на премьерных показах!</strong></p>',
                'image' => '/images/news/vyzyvali-premiere.jpg',
                'published_at' => Carbon::now()->subDays(5),
                'is_published' => true
            ],
            [
                'title' => 'Гастроли в Казани',
                'title_tatar' => 'Казанда гастрольләр',
                'content' => '<p>Наш театр отправляется на гастроли в Казань! В программе: "Әниләр һәм бәбиләр", "Ак калфак" и "Галиябану".</p><p>Билеты уже в продаже. Спешите!</p>',
                'image' => '/images/news/gastroli.jpg',
                'published_at' => Carbon::now()->subDays(2),
                'is_published' => true
            ],
            [
                'title' => 'Мастер-класс для детей',
                'title_tatar' => 'Балалар өчен остаханә',
                'content' => '<p>Приглашаем детей от 7 до 14 лет на мастер-класс по актерскому мастерству. Занятия проводит заслуженная артистка Гульшат Гайсина.</p><p>Начало: каждую субботу в 11:00. Запись по телефону +7 (8552) 123-45-67.</p>',
                'image' => '/images/news/master-class.jpg',
                'published_at' => Carbon::now()->subDays(1),
                'is_published' => true
            ],
            [
                'title' => 'Новогодние представления',
                'title_tatar' => 'Яңа ел тамашалары',
                'content' => '<p>Спешите купить билеты на новогодние представления! Вас ждут волшебные сказки, Дед Мороз и Снегурочка, подарки и хорошее настроение.</p><p>Продажа билетов открыта с 1 декабря.</p>',
                'image' => '/images/news/new-year.jpg',
                'published_at' => Carbon::now()->addDays(10),
                'is_published' => true
            ]
        ];

        foreach ($newsData as $data) {
            News::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }

        $this->command->info('✅ Театр успешно заполнен данными!');
        $this->command->info('📊 Спектаклей: ' . Spectacle::count());
        $this->command->info('🎭 Актеров: ' . Actor::count());
        $this->command->info('📅 Показов: ' . Show::count());
        $this->command->info('📰 Новостей: ' . News::count());
        $this->command->info('👤 Тестовый пользователь: test@example.com / password');
    }
}
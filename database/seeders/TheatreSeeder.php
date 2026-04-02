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
                'name' => 'Гаффанов Ильназ',
                'name_tatar' => 'Гаффанов Ильназ',
                'biography' => 'Народный артист Республики Татарстан. Окончил Елабужский колледж культуры и искусств, работал актером в Туймазинском государственном татарском драматическом театре. С 2024 года – актер Набережночелнинского татарского драматического театра имени Аяза Гилязова.',
                'category' => 'Народный артист',
                'photo' => '/images/actors/ilnur.jpg',
                'awards' => json_encode(['Государственная премия им. Г.Тукая', 'Заслуженный артист РТ'])
            ],
            [
                'name' => 'Мухлисова Алина',
                'name_tatar' => 'Мухлисова Алина',
                'biography' => 'Заслуженная артистка Республики Татарстан. Окончила Казанскую государственную консерваторию. Обладательница премии "Тантана". Создает яркие, запоминающиеся образы на сцене.',
                'category' => 'Заслуженный артист',
                'photo' => '/images/actors/gulshat.jpg',
                'awards' => json_encode(['Премия "Тантана"', 'Заслуженный артист РТ'])
            ],
            [
                'name' => 'Сафин Фирдус',
                'name_tatar' => 'Сафин Фирдус',
                'biography' => 'Молодой талантливый актер, выпускник Казанского театрального училища. Лауреат молодежной премии "Новая волна". Обладает широким творческим диапазоном.',
                'category' => 'Артист',
                'photo' => '/images/actors/aydar.jpg',
                'awards' => json_encode(['Молодежная премия "Новая волна"'])
            ],
            [
                'name' => 'Галиуллина Зульфия',
                'name_tatar' => 'Галиуллина Зульфия',
                'biography' => 'Заслуженная артистка Республики Татарстан. Окончив Казанское театральное училище, начала работать в Набережночелнинском татарском театре. Поступила на заочное отделение Казанского государственного института культуры и искусств. Артистке хорошо удаются острохарактерные роли.',
                'category' => 'Заслуженный артист',
                'photo' => '/images/actors/lyaysan.jpg',
                'awards' => json_encode(['Заслуженный артист РТ', 'Премия "Идел-йорт"'])
            ],
            [
                'name' => 'Ибрагимов Руслан',
                'name_tatar' => 'Ибрагимов Руслан',
                'biography' => 'Заслуженный артист Республики Татарстан. Окончил актерское отделение Казанского театрального училища, заочное отделение Казанского государственного института культуры и искусств. ',
                'category' => 'Артист',
                'photo' => '/images/actors/ramil.jpg',
                'awards' => json_encode(['Лауреат фестиваля "Науруз"'])
            ],
            [
                'name' => 'Сагидуллина Алсу',
                'name_tatar' => 'Сагидуллина Алсу',
                'biography' => 'Народная артистка Республики Татарстан. Окончила Елабужский колледж культуры и искусств факультет «Актерское искусство». В 2023 году была принята в Набережночелнинский государственный татарский драматический театр. Победитель ежегодного театрального конкурса и премии Министерства культуры Республики Татарстан «Тантана» ',
                'category' => 'Народный артист',
                'photo' => '/images/actors/nailya.jpg',
                'awards' => json_encode(['Народный артист РТ', 'Орден "Дуслык"', 'Государственная премия им. Г.Тукая'])
            ],
            [
                'name' => 'Фахертдинов Разиль',
                'name_tatar' => 'Фахертдинов Разиль',
                'biography' => 'Заслуженный артист Республики Татарстан. Мастер сцены, одинаково успешно играет в драме и комедии.',
                'category' => 'Заслуженный артист',
                'photo' => '/images/actors/albert.jpg',
                'awards' => json_encode(['Заслуженный артист РТ'])
            ],
            [
                'name' => 'Маликова Индира',
                'name_tatar' => 'Маликова Индира',
                'biography' => 'Молодая актриса, выпускница Казанского театрального училища. Обладает яркой внешностью и талантом. Быстро завоевала любовь зрителей.',
                'category' => 'Артист',
                'photo' => '/images/actors/zulfiya.jpg',
                'awards' => json_encode(['Лауреат премии «Тантана»'])
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
                'Гаффанов Ильназ' => 'Главная роль',
                'Мухлисова Алина' => 'Главная роль',
                'Сафин Фирдус' => 'Вторая роль',
                'Ибрагимов Руслан' => 'Эпизодическая роль'
            ],
            'Пробка' => [
                'Гаффанов Ильназ' => 'Водитель',
                'Галиуллина Зульфия' => 'Пассажирка',
                'Фахертдинов Разиль' => 'Второй водитель'
            ],
            'Олень' => [
                'Сагидуллина Алсу' => 'Мать',
                'Ибрагимов Руслан' => 'Сын',
                'Маликова Индира' => 'Дочь'
            ],
            'Любовница' => [
                'Мухлисова Алина' => 'Любовница',
                'Гаффанов Ильназ' => 'Муж',
                'Галиуллина Зульфия' => 'Жена'
            ],
            'Молодые сердца' => [
                'Сафин Фирдус' => 'Молодой человек',
                'Маликова Индира' => 'Девушка',
                'Ибрагимов Руслан' => 'Друг'
            ],
            'Су анасы' => [
                'Мухлисова Алина' => 'Су анасы',
                'Гаффанов Ильназ' => 'Крестьянин',
                'Сафин Фирдус' => 'Сын'
            ],
            'Әниләр һәм бәбиләр' => [
                'Сагидуллина Алсу' => 'Әни',
                'Фахертдинов Разиль' => 'Атай',
                'Маликова Индира' => 'Кыз'
            ],
            'Ак калфак' => [
                'Гаффанов Ильназ' => 'Главная роль',
                'Галиуллина Зульфия' => 'Главная роль',
                'Сагидуллина Алсу' => 'Вторая роль'
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
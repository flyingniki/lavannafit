<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@fitonline.ru'],
            [
                'name'     => 'Администратор',
                'password' => Hash::make('Admin1234!'),
                'is_admin' => true,
            ]
        );

        // Default tariffs
        $tariffs = [
            ['name' => 'Старт',    'price' => '4 900',  'period' => 'мес', 'sort_order' => 1, 'description' => 'Индивидуальная программа тренировок, базовый план питания, чат с тренером.', 'features' => ['Программа тренировок', 'План питания', 'Чат с тренером (будни)', 'Ежемесячная корректировка']],
            ['name' => 'Развитие', 'price' => '7 900',  'period' => 'мес', 'sort_order' => 2, 'description' => 'Полноценное ведение: тренировки, питание, ежедневная обратная связь.', 'features' => ['Программа тренировок', 'Детальный план питания', 'Чат 7 дней в неделю', 'Еженедельная корректировка', 'Анализ техники по видео']],
            ['name' => 'Премиум',  'price' => '12 900', 'period' => 'мес', 'sort_order' => 3, 'description' => 'VIP-ведение с видеосессиями и максимальным погружением.', 'features' => ['Всё из тарифа «Развитие»', '2 видеосессии в месяц', 'Психологическая поддержка', 'Приоритетный ответ', 'Гарантия результата']],
        ];

        foreach ($tariffs as $t) {
            Tariff::updateOrCreate(['name' => $t['name']], $t);
        }

        // Default reviews
        $reviews = [
            ['name' => 'Анна К.',   'city' => 'Москва',          'sort_order' => 1, 'text' => 'За 3 месяца минус 8 кг! Самое главное — без голодовок. Тренер всегда на связи, поддерживает и корректирует план под мой график.'],
            ['name' => 'Марина С.', 'city' => 'Санкт-Петербург', 'sort_order' => 2, 'text' => 'Наконец-то нашла тренера, который понимает, что у меня нет 2 часов в день на спорт. Тренировки по 40 минут — и результат заметен.'],
            ['name' => 'Ольга Т.',  'city' => 'Екатеринбург',    'sort_order' => 3, 'text' => 'Подруга посоветовала. Сначала не верила, что онлайн это вообще работает. Теперь сама всем советую. Спасибо огромное!'],
        ];

        foreach ($reviews as $r) {
            Review::updateOrCreate(['name' => $r['name'], 'city' => $r['city']], $r);
        }

        // Default settings
        $settings = [
            'whatsapp_phone'  => '79000000000',
            'stat_clients'    => '200+',
            'stat_years'      => '5 лет',
            'seo_title'       => 'Онлайн-тренер — персональное ведение по всей России',
            'seo_description' => 'Онлайн-тренировки для женщин 30+. Индивидуальный план питания и тренировок, поддержка 24/7.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}

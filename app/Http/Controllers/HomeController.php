<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Result;
use App\Models\Setting;
use App\Models\Tariff;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::getMany([
            'hero_title', 'hero_subtitle', 'hero_badge', 'hero_cta',
            'whatsapp_phone', 'stat_clients', 'stat_years',
            'about_title', 'about_text1', 'about_text2', 'trainer_name',
            'about_experience_years', 'about_achievements', 'about_photo',
            'seo_title', 'seo_description',
        ]);

        $tariffs = Tariff::where('is_active', true)->orderBy('sort_order')->get()->map(fn($t) => [
            'name'        => $t->name,
            'price'       => $t->price,
            'period'      => $t->period,
            'description' => $t->description,
            'features'    => $t->features ?? [],
        ]);

        $reviews = Review::where('is_active', true)->orderBy('sort_order')->get()->map(fn($r) => [
            'name' => $r->name,
            'city' => $r->city,
            'text' => $r->text,
        ]);

        $results = Result::where('is_active', true)->orderBy('sort_order')->get()->map(fn($r) => [
            'image' => $r->image_path ? asset('storage/' . $r->image_path) : null,
            'alt'   => $r->title ?? 'Результат',
        ]);

        // Fallback defaults when DB is empty
        if ($tariffs->isEmpty()) {
            $tariffs = collect([
                ['name' => 'Старт',    'price' => '4 900',  'period' => 'мес', 'description' => 'Индивидуальная программа тренировок, базовый план питания, чат с тренером.', 'features' => ['Программа тренировок', 'План питания', 'Чат с тренером (будни)', 'Ежемесячная корректировка']],
                ['name' => 'Развитие', 'price' => '7 900',  'period' => 'мес', 'description' => 'Полноценное ведение: тренировки, питание, ежедневная обратная связь.', 'features' => ['Программа тренировок', 'Детальный план питания', 'Чат 7 дней в неделю', 'Еженедельная корректировка', 'Анализ техники по видео']],
                ['name' => 'Премиум',  'price' => '12 900', 'period' => 'мес', 'description' => 'VIP-ведение с видеосессиями и максимальным погружением.', 'features' => ['Всё из тарифа «Развитие»', '2 видеосессии в месяц', 'Психологическая поддержка', 'Приоритетный ответ', 'Гарантия результата']],
            ]);
        }

        return Inertia::render('Home', [
            'seo' => [
                'title'       => $settings['seo_title']       ?? 'Онлайн-тренер — персональное ведение по всей России',
                'description' => $settings['seo_description'] ?? 'Онлайн-тренировки для женщин 30+. Индивидуальный план питания и тренировок, поддержка 24/7.',
            ],
            'tariffs' => $tariffs,
            'reviews' => $reviews->isEmpty() ? null : $reviews,
            'results' => $results->isEmpty() ? null : $results,
            'settings' => [
                'hero_title'     => $settings['hero_title']     ?? null,
                'hero_subtitle'  => $settings['hero_subtitle']  ?? null,
                'hero_badge'     => $settings['hero_badge']     ?? null,
                'hero_cta'       => $settings['hero_cta']       ?? null,
                'whatsapp_phone' => $settings['whatsapp_phone'] ?? '79000000000',
                'stat_clients'   => $settings['stat_clients']   ?? '200+',
                'stat_years'     => $settings['stat_years']     ?? '5 лет',
                'about_title'    => $settings['about_title']    ?? null,
                'about_text1'    => $settings['about_text1']    ?? null,
                'about_text2'    => $settings['about_text2']    ?? null,
                'trainer_name'   => $settings['trainer_name']   ?? null,
                'about_experience_years' => $settings['about_experience_years'] ?? '5+',
                'about_achievements'     => $settings['about_achievements'] ?? null,
                'about_photo_url'        => !empty($settings['about_photo'])
                    ? asset('storage/' . $settings['about_photo'])
                    : null,
            ],
        ]);
    }
}

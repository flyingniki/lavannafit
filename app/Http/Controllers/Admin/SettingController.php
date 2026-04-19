<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    private array $keys = [
        'hero_title',
        'hero_subtitle',
        'hero_badge',
        'hero_cta',
        'whatsapp_phone',
        'stat_clients',
        'stat_years',
        'about_title',
        'about_text1',
        'about_text2',
        'trainer_name',
        'about_experience_years',
        'about_achievements',
        'about_photo',
        'seo_title',
        'seo_description',
    ];

    public function index(): Response
    {
        $settings = Setting::getMany($this->keys);

        $settings['about_photo_url'] = !empty($settings['about_photo'])
            ? asset('storage/' . $settings['about_photo'])
            : null;

        return Inertia::render('Admin/Settings', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'hero_title'      => ['nullable', 'string', 'max:200'],
            'hero_subtitle'   => ['nullable', 'string', 'max:500'],
            'hero_badge'      => ['nullable', 'string', 'max:200'],
            'hero_cta'        => ['nullable', 'string', 'max:200'],
            'whatsapp_phone'  => ['nullable', 'string', 'max:20'],
            'stat_clients'    => ['nullable', 'string', 'max:50'],
            'stat_years'      => ['nullable', 'string', 'max:50'],
            'about_title'     => ['nullable', 'string', 'max:200'],
            'about_text1'     => ['nullable', 'string', 'max:1000'],
            'about_text2'     => ['nullable', 'string', 'max:1000'],
            'trainer_name'    => ['nullable', 'string', 'max:100'],
            'about_experience_years' => ['nullable', 'string', 'max:20'],
            'about_achievements'     => ['nullable', 'string', 'max:3000'],
            'about_photo'            => ['nullable', 'image', 'max:4096'],
            'remove_about_photo'     => ['nullable', 'boolean'],
            'seo_title'       => ['nullable', 'string', 'max:200'],
            'seo_description' => ['nullable', 'string', 'max:500'],
        ]);

        if (($data['remove_about_photo'] ?? false) === true) {
            $oldPath = Setting::get('about_photo');
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            Setting::set('about_photo', null);
        }

        if ($request->hasFile('about_photo')) {
            $oldPath = Setting::get('about_photo');
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }

            $newPath = $request->file('about_photo')->store('trainer', 'public');
            Setting::set('about_photo', $newPath);
        }

        unset($data['about_photo'], $data['remove_about_photo']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings')->with('success', 'Настройки сохранены.');
    }
}

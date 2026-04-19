<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Inertia::share([
            'flash' => fn () => [
                'success' => session('success'),
                'error'   => session('error'),
            ],
            'errors' => fn () => session()->get('errors')
                ? session()->get('errors')->getBag('default')->getMessages()
                : (object) [],
        ]);
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\SettingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::view('/privacy', 'privacy')->name('privacy');

// Admin auth
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Tariffs
        Route::get('/tariffs', [TariffController::class, 'index'])->name('tariffs');
        Route::post('/tariffs', [TariffController::class, 'store'])->name('tariffs.store');
        Route::put('/tariffs/{tariff}', [TariffController::class, 'update'])->name('tariffs.update');
        Route::delete('/tariffs/{tariff}', [TariffController::class, 'destroy'])->name('tariffs.destroy');

        // Reviews
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // Results
        Route::get('/results', [ResultController::class, 'index'])->name('results');
        Route::post('/results', [ResultController::class, 'store'])->name('results.store');
        Route::post('/results/{result}', [ResultController::class, 'update'])->name('results.update');
        Route::delete('/results/{result}', [ResultController::class, 'destroy'])->name('results.destroy');

        // Contacts (incoming leads)
        Route::get('/contacts', [ContactAdminController::class, 'index'])->name('contacts');
        Route::patch('/contacts/{contact}/read', [ContactAdminController::class, 'markRead'])->name('contacts.read');
        Route::delete('/contacts/{contact}', [ContactAdminController::class, 'destroy'])->name('contacts.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});


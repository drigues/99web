<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackageRequestController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

// ─── SEO ──────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt',  [SitemapController::class, 'robots'])->name('robots');

// ─── Público ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/contacto', [ContactController::class, 'store'])
    ->name('contacto.store')
    ->middleware('throttle:30,1');

// ─── Pacotes ───────────────────────────────────────────────────
Route::get('/pacotes/obrigado', [PackageRequestController::class, 'obrigado'])->name('pacotes.obrigado');
Route::get('/pacotes/{type}', [PackageRequestController::class, 'show'])->name('pacotes.show')
    ->where('type', 'essencial|corporativo|personalizado');
Route::post('/pacotes/{type}', [PackageRequestController::class, 'store'])
    ->name('pacotes.store')
    ->where('type', 'essencial|corporativo|personalizado')
    ->middleware('throttle:20,1');

// ─── Blog público ─────────────────────────────────────────────
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/',                 [BlogController::class, 'index'])->name('index');
    Route::get('/feed.rss',         [BlogController::class, 'feed'])->name('feed');
    Route::get('/categoria/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{slug}',       [BlogController::class, 'tag'])->name('tag');
    Route::get('/{slug}',           [BlogController::class, 'show'])->name('show');
});

// ─── Demo / Portfólio ────────────────────────────────────────────
Route::get('/demo/acccro', [DemoController::class, 'acccro'])->name('demo.acccro');

// ─── Admin (Filament) ─── /admin → gerido por Filament 3

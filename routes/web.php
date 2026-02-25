<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackageRequestController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminPackageRequestController;
use App\Http\Controllers\Admin\AdminMeetingController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// ─── SEO ──────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt',  [SitemapController::class, 'robots'])->name('robots');

// ─── Público ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');

// ─── Pacotes ───────────────────────────────────────────────────
Route::get('/pacotes/obrigado', [PackageRequestController::class, 'obrigado'])->name('pacotes.obrigado');
Route::get('/pacotes/{type}', [PackageRequestController::class, 'show'])->name('pacotes.show')
    ->where('type', 'essencial|corporativo|personalizado');
Route::post('/pacotes/{type}', [PackageRequestController::class, 'store'])->name('pacotes.store')
    ->where('type', 'essencial|corporativo|personalizado');

// ─── Blog público ─────────────────────────────────────────────
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/',                 [BlogController::class, 'index'])->name('index');
    Route::get('/feed.rss',         [BlogController::class, 'feed'])->name('feed');
    Route::get('/categoria/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{slug}',       [BlogController::class, 'tag'])->name('tag');
    Route::get('/{slug}',           [BlogController::class, 'show'])->name('show');
});

// ─── Admin ────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth pública
    Route::get('/login',  [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // ─── Rotas protegidas ────────────────────────────────────
    Route::middleware('admin.auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // API — contagem de notificações
        Route::get('/api/notifications-count', [DashboardController::class, 'notificationsCount'])
            ->name('api.notifications-count');

        // ── Contactos ──
        Route::get('/contactos',                    [AdminContactController::class, 'index'])->name('contactos.index');
        Route::get('/contactos/{contact}',          [AdminContactController::class, 'show'])->name('contactos.show');
        Route::patch('/contactos/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contactos.updateStatus');
        Route::patch('/contactos/{contact}/notes',  [AdminContactController::class, 'updateNotes'])->name('contactos.updateNotes');
        Route::delete('/contactos/{contact}',       [AdminContactController::class, 'destroy'])->name('contactos.destroy');

        // ── Pedidos de pacotes ──
        Route::get('/pedidos',                       [AdminPackageRequestController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}',              [AdminPackageRequestController::class, 'show'])->name('pedidos.show');
        Route::patch('/pedidos/{pedido}/status',     [AdminPackageRequestController::class, 'updateStatus'])->name('pedidos.updateStatus');
        Route::patch('/pedidos/{pedido}/notes',      [AdminPackageRequestController::class, 'updateNotes'])->name('pedidos.updateNotes');
        Route::delete('/pedidos/{pedido}',           [AdminPackageRequestController::class, 'destroy'])->name('pedidos.destroy');

        // ── Reuniões ──
        Route::get('/reunioes',                      [AdminMeetingController::class, 'index'])->name('reunioes.index');
        Route::get('/reunioes/{reuniao}',            [AdminMeetingController::class, 'show'])->name('reunioes.show');
        Route::patch('/reunioes/{reuniao}/status',   [AdminMeetingController::class, 'updateStatus'])->name('reunioes.updateStatus');
        Route::post('/reunioes/{reuniao}/confirm',   [AdminMeetingController::class, 'confirm'])->name('reunioes.confirm');
        Route::patch('/reunioes/{reuniao}/notes',    [AdminMeetingController::class, 'updateNotes'])->name('reunioes.updateNotes');
        Route::delete('/reunioes/{reuniao}',         [AdminMeetingController::class, 'destroy'])->name('reunioes.destroy');

        // ── Stubs (blog, configurações) ──
        Route::get('/blog',            fn () => abort(404))->name('blog.index');
        Route::get('/blog/categorias', fn () => abort(404))->name('blog.categorias.index');
        Route::get('/configuracoes',   fn () => abort(404))->name('configuracoes.index');

    });

});

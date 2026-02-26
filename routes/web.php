<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackageRequestController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminPackageRequestController;
use App\Http\Controllers\Admin\AdminMeetingController;
use App\Http\Controllers\Admin\AdminBlogPostController;
use App\Http\Controllers\Admin\AdminBlogCategoryController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\DashboardController;
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
Route::get('/demo/accro', [DemoController::class, 'accro'])->name('demo.accro');

// ─── Admin ────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth pública
    Route::get('/login',   [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AdminLoginController::class, 'login'])->name('login.post')->middleware('throttle:10,1');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // ─── Rotas protegidas ────────────────────────────────────
    Route::middleware('admin.auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // API — contagem de notificações
        Route::get('/api/notifications-count', [DashboardController::class, 'notificationsCount'])
            ->name('api.notifications-count');

        // ── Contactos ──
        Route::get('/contactos',                     [AdminContactController::class, 'index'])->name('contactos.index');
        Route::get('/contactos/exportar',            [AdminContactController::class, 'export'])->name('contactos.export');
        Route::get('/contactos/{contact}',           [AdminContactController::class, 'show'])->name('contactos.show');
        Route::patch('/contactos/{contact}/status',  [AdminContactController::class, 'updateStatus'])->name('contactos.updateStatus');
        Route::patch('/contactos/{contact}/notes',   [AdminContactController::class, 'updateNotes'])->name('contactos.updateNotes');
        Route::delete('/contactos/{contact}',        [AdminContactController::class, 'destroy'])->name('contactos.destroy');

        // ── Pedidos de pacotes ──
        Route::get('/pedidos',                        [AdminPackageRequestController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/exportar',               [AdminPackageRequestController::class, 'export'])->name('pedidos.export');
        Route::get('/pedidos/{pedido}',               [AdminPackageRequestController::class, 'show'])->name('pedidos.show');
        Route::patch('/pedidos/{pedido}/status',      [AdminPackageRequestController::class, 'updateStatus'])->name('pedidos.updateStatus');
        Route::patch('/pedidos/{pedido}/notes',       [AdminPackageRequestController::class, 'updateNotes'])->name('pedidos.updateNotes');
        Route::delete('/pedidos/{pedido}',            [AdminPackageRequestController::class, 'destroy'])->name('pedidos.destroy');

        // ── Reuniões ──
        Route::get('/reunioes',                       [AdminMeetingController::class, 'index'])->name('reunioes.index');
        Route::get('/reunioes/exportar',              [AdminMeetingController::class, 'export'])->name('reunioes.export');
        Route::get('/reunioes/{reuniao}',             [AdminMeetingController::class, 'show'])->name('reunioes.show');
        Route::patch('/reunioes/{reuniao}/status',    [AdminMeetingController::class, 'updateStatus'])->name('reunioes.updateStatus');
        Route::post('/reunioes/{reuniao}/confirm',    [AdminMeetingController::class, 'confirm'])->name('reunioes.confirm');
        Route::patch('/reunioes/{reuniao}/notes',     [AdminMeetingController::class, 'updateNotes'])->name('reunioes.updateNotes');
        Route::delete('/reunioes/{reuniao}',          [AdminMeetingController::class, 'destroy'])->name('reunioes.destroy');

        // ── Blog — posts (estáticos ANTES de {post}) ──
        Route::get('/blog',                        [AdminBlogPostController::class, 'index'])->name('blog.index');
        Route::get('/blog/criar',                  [AdminBlogPostController::class, 'create'])->name('blog.create');
        Route::post('/blog',                       [AdminBlogPostController::class, 'store'])->name('blog.store');
        Route::post('/blog/bulk',                  [AdminBlogPostController::class, 'bulk'])->name('blog.bulk');

        // ── Blog — categorias (estático ANTES de {post}) ──
        Route::get('/blog/categorias',               [AdminBlogCategoryController::class, 'index'])->name('blog.categorias.index');
        Route::post('/blog/categorias',              [AdminBlogCategoryController::class, 'store'])->name('blog.categorias.store');
        Route::patch('/blog/categorias/reorder',     [AdminBlogCategoryController::class, 'reorder'])->name('blog.categorias.reorder');
        Route::put('/blog/categorias/{category}',    [AdminBlogCategoryController::class, 'update'])->name('blog.categorias.update');
        Route::delete('/blog/categorias/{category}', [AdminBlogCategoryController::class, 'destroy'])->name('blog.categorias.destroy');

        // ── Blog — posts dinâmicos ──
        Route::get('/blog/{post}/editar',          [AdminBlogPostController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{post}',                 [AdminBlogPostController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{post}',              [AdminBlogPostController::class, 'destroy'])->name('blog.destroy');
        Route::patch('/blog/{post}/publish',       [AdminBlogPostController::class, 'togglePublish'])->name('blog.togglePublish');
        Route::post('/blog/{post}/duplicate',      [AdminBlogPostController::class, 'duplicate'])->name('blog.duplicate');
        Route::get('/blog/{post}/preview',         [AdminBlogPostController::class, 'preview'])->name('blog.preview');

        // ── API — upload de imagem ──
        Route::post('/api/upload-image',           [AdminBlogPostController::class, 'uploadImage'])->name('api.upload-image');

        // ── Configurações ──
        Route::get('/configuracoes',  [AdminSettingsController::class, 'index'])->name('configuracoes.index');
        Route::post('/configuracoes', [AdminSettingsController::class, 'update'])->name('configuracoes.update');
        Route::post('/configuracoes/logo', [AdminSettingsController::class, 'uploadLogo'])->name('configuracoes.logo');

        // ── Perfil ──
        Route::get('/perfil',             [AdminProfileController::class, 'index'])->name('perfil.index');
        Route::put('/perfil',             [AdminProfileController::class, 'update'])->name('perfil.update');
        Route::put('/perfil/senha',       [AdminProfileController::class, 'updatePassword'])->name('perfil.password');

        // ── Atividade ──
        Route::get('/atividade',          [AdminActivityController::class, 'index'])->name('atividade.index');

    });

});

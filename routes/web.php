<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackageRequestController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// ─── Público ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');

// ─── Pacotes ───────────────────────────────────────────────────
Route::get('/pacotes/obrigado', [PackageRequestController::class, 'obrigado'])->name('pacotes.obrigado');
Route::get('/pacotes/{type}', [PackageRequestController::class, 'show'])->name('pacotes.show')
    ->where('type', 'essencial|corporativo|personalizado');
Route::post('/pacotes/{type}', [PackageRequestController::class, 'store'])->name('pacotes.store')
    ->where('type', 'essencial|corporativo|personalizado');

// ─── Admin ────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth pública
    Route::get('/login',  [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // ─── Rotas protegidas ────────────────────────────────────
    Route::middleware('admin.auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Stubs — implementação futura
        Route::get('/contactos',       fn () => abort(404))->name('contactos.index');
        Route::get('/contactos/{id}',  fn () => abort(404))->name('contactos.show');
        Route::get('/pedidos',         fn () => abort(404))->name('pedidos.index');
        Route::get('/pedidos/{id}',    fn () => abort(404))->name('pedidos.show');
        Route::get('/reunioes',        fn () => abort(404))->name('reunioes.index');
        Route::get('/reunioes/{id}',   fn () => abort(404))->name('reunioes.show');
        Route::get('/blog',            fn () => abort(404))->name('blog.index');
        Route::get('/blog/categorias', fn () => abort(404))->name('blog.categorias.index');
        Route::get('/configuracoes',   fn () => abort(404))->name('configuracoes.index');

    });

});

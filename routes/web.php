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

// ─── Admin: autenticação (sem middleware) ─────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',  [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // ─── Admin: rotas protegidas ──────────────────────────────
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

});

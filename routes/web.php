<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

// Site Público
Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/lojas', [SiteController::class, 'lojas'])->name('site.lojas');
Route::get('/sobre', [SiteController::class, 'sobre'])->name('site.sobre');
Route::get('/ofertas', [SiteController::class, 'ofertas'])->name('site.ofertas');
Route::get('/trabalhe_conosco', [SiteController::class, 'trabalheConosco'])->name('site.trabalhe');

// Auth
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Cliente - Cadastrar currículo
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/cadastrar-curriculo', [CurriculoController::class, 'create'])->name('site.curriculo');
    Route::post('/cadastrar-curriculo', [CurriculoController::class, 'store'])->name('site.curriculo.store');
});

// Dashboard
Route::middleware(['auth'])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // RH
    Route::middleware('role:rh,admin')->prefix('/rh')->name('rh.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/vagas', [VagaController::class, 'index'])->name('vagas');
        Route::get('/vagas/criar', [VagaController::class, 'create'])->name('vagas.create');
        Route::post('/vagas', [VagaController::class, 'store'])->name('vagas.store');
        Route::get('/vagas/{vaga}/editar', [VagaController::class, 'edit'])->name('vagas.edit');
        Route::put('/vagas/{vaga}', [VagaController::class, 'update'])->name('vagas.update');
        Route::delete('/vagas/{vaga}', [VagaController::class, 'destroy'])->name('vagas.destroy');
        Route::get('/vagas/{vaga}/candidaturas', [VagaController::class, 'candidaturas'])->name('vagas.candidaturas');
        Route::get('/curriculos', [CurriculoController::class, 'listar'])->name('curriculos');
        Route::get('/curriculos/{curriculo}/download', [CurriculoController::class, 'download'])->name('curriculos.download');
        Route::get('/curriculos/{curriculo}/imprimir', [CurriculoController::class, 'imprimir'])->name('curriculos.imprimir');
        Route::put('/candidaturas/{candidatura}/status', [CurriculoController::class, 'updateStatus'])->name('candidaturas.status');
    });

    // Marketing
    Route::middleware('role:marketing,admin')->prefix('/marketing')->name('marketing.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/ofertas', [OfertaController::class, 'index'])->name('ofertas');
        Route::get('/ofertas/criar', [OfertaController::class, 'create'])->name('ofertas.create');
        Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store');
        Route::get('/ofertas/{oferta}/editar', [OfertaController::class, 'edit'])->name('ofertas.edit');
        Route::put('/ofertas/{oferta}', [OfertaController::class, 'update'])->name('ofertas.update');
        Route::delete('/ofertas/{oferta}', [OfertaController::class, 'destroy'])->name('ofertas.destroy');
    });

    // Admin / TI
    Route::middleware('role:admin')->prefix('/admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings');
        Route::post('/content', [AdminController::class, 'updateContent'])->name('content');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
        Route::get('/content-json', [AdminController::class, 'getContentJson'])->name('content.json');
    });
});

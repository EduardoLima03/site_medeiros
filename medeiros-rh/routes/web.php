<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\DashboardController;

// Página pública
Route::get('/', [SiteController::class, 'home'])->name('site.home');

// Autenticação
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Cliente - Cadastrar currículo
Route::middleware(['auth'])->group(function () {
    Route::get('/curriculo/cadastrar', [CurriculoController::class, 'create'])->name('site.curriculo');
    Route::post('/curriculo/cadastrar', [CurriculoController::class, 'store'])->name('site.curriculo.store');
});

// Dashboard
Route::middleware(['auth'])->prefix('/dashboard')->name('rh.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::middleware('role:rh,admin')->group(function () {
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
});

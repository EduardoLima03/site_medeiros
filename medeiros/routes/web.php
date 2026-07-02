<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;

// Site Público
Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/lojas', [SiteController::class, 'lojas'])->name('site.lojas');
Route::get('/sobre', [SiteController::class, 'sobre'])->name('site.sobre');
Route::get('/ofertas', [SiteController::class, 'ofertas'])->name('site.ofertas');
Route::redirect('/trabalhe_conosco', env('RH_SITE_URL', 'http://localhost:8001'))->name('site.trabalhe');

// Auth
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware(['auth'])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::get('/pages', [AdminController::class, 'pages'])->name('pages');
        Route::get('/appearance', [AdminController::class, 'appearance'])->name('appearance');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings');
        Route::post('/content', [AdminController::class, 'updateContent'])->name('content');
        Route::post('/page', [AdminController::class, 'createPage'])->name('page.create');
        Route::post('/section', [AdminController::class, 'createSection'])->name('section.create');
        Route::delete('/section/{pageContent}', [AdminController::class, 'deleteSection'])->name('section.delete');
        Route::get('/menu', [AdminController::class, 'menu'])->name('menu');
        Route::post('/menu/add', [AdminController::class, 'addMenuItem'])->name('menu.add');
        Route::delete('/menu/{index}', [AdminController::class, 'removeMenuItem'])->name('menu.remove');
        Route::post('/menu/mover/{index}', [AdminController::class, 'moveMenuItem'])->name('menu.mover');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
        Route::get('/content-json', [AdminController::class, 'getContentJson'])->name('content.json');
        Route::get('/media', [MediaController::class, 'index'])->name('media');
        Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
        Route::post('/media/upload-json', [MediaController::class, 'uploadJson'])->name('media.upload-json');
        Route::get('/media-list-json', [MediaController::class, 'libraryList'])->name('media.list-json');
    });
});

// Páginas dinâmicas
Route::get('/pagina/{slug}', [SiteController::class, 'pagina'])->name('site.pagina');

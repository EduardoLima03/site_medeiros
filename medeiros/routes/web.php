<?php

use App\Http\Controllers\AchadoPerdidoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PageBlockController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VagaController;
use Illuminate\Support\Facades\Route;

// Site Público
Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/lojas', [SiteController::class, 'lojas'])->name('site.lojas');
Route::get('/sobre', [SiteController::class, 'sobre'])->name('site.sobre');
Route::get('/ofertas', [SiteController::class, 'ofertas'])->name('site.ofertas');
Route::get('/achados-perdidos', [SiteController::class, 'achados'])->name('site.achados');
Route::get('/trabalhe-conosco', [SiteController::class, 'trabalhe'])->name('site.trabalhe');
Route::redirect('/trabalhe_conosco', '/trabalhe-conosco', 301);

// Currículo (cliente autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/curriculo/cadastrar', [CurriculoController::class, 'create'])->name('site.curriculo');
    Route::post('/curriculo/cadastrar', [CurriculoController::class, 'store'])->name('site.curriculo.store');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

        Route::get('/achados', [AchadoPerdidoController::class, 'index'])->name('achados');
        Route::get('/achados/criar', [AchadoPerdidoController::class, 'create'])->name('achados.create');
        Route::post('/achados', [AchadoPerdidoController::class, 'store'])->name('achados.store');
        Route::get('/achados/{achado}/editar', [AchadoPerdidoController::class, 'edit'])->name('achados.edit');
        Route::put('/achados/{achado}', [AchadoPerdidoController::class, 'update'])->name('achados.update');
        Route::delete('/achados/{achado}', [AchadoPerdidoController::class, 'destroy'])->name('achados.destroy');
    });

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

        // Blocos de conteúdo (edição visual)
        Route::get('/blocos', [PageBlockController::class, 'index'])->name('blocks');
        Route::post('/blocos', [PageBlockController::class, 'store'])->name('blocks.store');
        Route::match(['post', 'put'], '/blocos/reordenar', [PageBlockController::class, 'reorder'])->name('blocks.reorder');
        Route::get('/blocos/{block}/editar', [PageBlockController::class, 'edit'])->name('blocks.edit');
        Route::put('/blocos/{block}', [PageBlockController::class, 'update'])->name('blocks.update');
        Route::delete('/blocos/{block}', [PageBlockController::class, 'destroy'])->name('blocks.destroy');
    });
});

// Páginas dinâmicas
Route::get('/pagina/{slug}', [SiteController::class, 'pagina'])->name('site.pagina');

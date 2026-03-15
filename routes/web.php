<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ─────────────────────────────────────────────
// Autenticación
// ─────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.store')
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ─────────────────────────────────────────────
// Panel de administración
// ─────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Páginas
    Route::get('/pages', fn () => view('admin.pages.index'))->name('pages.index');
    Route::get('/pages/create', fn () => view('admin.pages.create'))->name('pages.create');
    Route::get('/pages/{page}/edit', fn (Page $page) => view('admin.pages.edit', ['page' => $page]))->name('pages.edit');

    // Actividades
    Route::get('/activities', fn () => view('admin.activities.index'))->name('activities.index');
    Route::get('/activities/create', fn () => view('admin.activities.create'))->name('activities.create');
    Route::get('/activities/{activity}/edit', fn ($activity) => view('admin.activities.edit', ['activity' => $activity]))->name('activities.edit');

    // Galerías
    Route::get('/galleries', fn () => view('admin.galleries.index'))->name('galleries.index');
    Route::get('/galleries/create', fn () => view('admin.galleries.create'))->name('galleries.create');
    Route::get('/galleries/{gallery}/manage', fn ($gallery) => view('admin.galleries.manage', ['gallery' => $gallery]))->name('galleries.manage');

    // Eventos
    Route::get('/events', fn () => view('admin.events.index'))->name('events.index');
    Route::get('/events/create', fn () => view('admin.events.create'))->name('events.create');
    Route::get('/events/{event}/edit', fn ($event) => view('admin.events.edit', ['event' => $event]))->name('events.edit');

    // Documentos
    Route::get('/documents', fn () => view('admin.documents.index'))->name('documents.index');
    Route::get('/documents/create', fn () => view('admin.documents.create'))->name('documents.create');
});

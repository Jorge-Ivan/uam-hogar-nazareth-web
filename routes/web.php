<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Website\ActivityController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\DocumentController;
use App\Http\Controllers\Website\DonationsController;
use App\Http\Controllers\Website\EventController;
use App\Http\Controllers\Website\GalleryController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\PageController;
use App\Models\Activity;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────
// Sitio web público
// ─────────────────────────────────────────────
Route::name('website.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/actividades', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/actividades/{slug}', [ActivityController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')->name('activities.show');
    Route::get('/galerias', [GalleryController::class, 'index'])->name('galleries.index');
    Route::get('/galerias/{slug}', [GalleryController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')->name('galleries.show');
    Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
    Route::get('/eventos/{slug}', [EventController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')->name('events.show');
    Route::get('/transparencia', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/paginas/{slug}', [PageController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')->name('pages.show');
    Route::get('/donaciones', [DonationsController::class, 'index'])->name('donations');
    Route::get('/contacto', [ContactController::class, 'index'])->name('contact');
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

// Recuperación de contraseña
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// ─────────────────────────────────────────────
// Panel de administración
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Rutas de contenido — Admin + Editor
    Route::middleware('panel')->group(function () {

        // Dashboard
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        // Páginas
        Route::get('/pages', fn () => view('admin.pages.index'))->name('pages.index');
        Route::get('/pages/create', fn () => view('admin.pages.create'))->name('pages.create');
        Route::get('/pages/{page}/edit', fn (Page $page) => view('admin.pages.edit', ['page' => $page]))->name('pages.edit');

        // Actividades
        Route::get('/activities', fn () => view('admin.activities.index'))->name('activities.index');
        Route::get('/activities/create', fn () => view('admin.activities.create'))->name('activities.create');
        Route::get('/activities/{activity}/edit', fn (Activity $activity) => view('admin.activities.edit', ['activity' => $activity]))->name('activities.edit');

        // Galerías
        Route::get('/galleries', fn () => view('admin.galleries.index'))->name('galleries.index');
        Route::get('/galleries/create', fn () => view('admin.galleries.create'))->name('galleries.create');
        Route::get('/galleries/{gallery}/manage', fn (Gallery $gallery) => view('admin.galleries.manage', ['gallery' => $gallery]))->name('galleries.manage');

        // Eventos
        Route::get('/events', fn () => view('admin.events.index'))->name('events.index');
        Route::get('/events/create', fn () => view('admin.events.create'))->name('events.create');
        Route::get('/events/{event}/edit', fn (Event $event) => view('admin.events.edit', ['event' => $event]))->name('events.edit');

        // Documentos
        Route::get('/documents', fn () => view('admin.documents.index'))->name('documents.index');
        Route::get('/documents/create', fn () => view('admin.documents.create'))->name('documents.create');
    });

    // Rutas exclusivas de administrador
    Route::middleware('admin')->group(function () {

        // Configuración
        Route::get('/settings', fn () => view('admin.settings.index'))->name('settings');

        // Usuarios
        Route::get('/users', fn () => view('admin.users.index'))->name('users.index');
        Route::get('/users/create', fn () => view('admin.users.create'))->name('users.create');
        Route::get('/users/{user}/edit', fn (\App\Models\User $user) => view('admin.users.edit', ['user' => $user]))->name('users.edit');
    });
});

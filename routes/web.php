<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\BuzonController;
use App\Http\Controllers\Alumno\AlumnoDashboardController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\SubdirectorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\BuzonAdminController;

// 🔴 Redirección raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// 🟢 REGISTRO (público)
Route::get('/registro', [RegistroController::class, 'create'])->name('registro');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');

// 🟢 RUTAS SOLO AUTH
Route::middleware(['auth', 'nocache'])->group(function () {

    // Perfil Laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paneles normales
    Route::view('/ventas', 'ventas')->name('ventas');
    Route::view('/productos', 'productos')->name('productos');

    // Perfil personalizado
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil');

    // Configuración
    Route::get('/configuracion', [ConfigController::class, 'index'])->name('configuracion');
    Route::put('/perfil/update', [ConfigController::class, 'updatePerfil'])->name('perfil.update');
    Route::put('/admin/notificaciones', [ConfigController::class, 'updateNotificaciones'])->name('admin.notificaciones.update');
    Route::patch('/admin/usuarios/{id}/toggle', [ConfigController::class, 'toggleUsuario'])->name('admin.usuarios.toggle');
    Route::delete('/admin/limpiar', [ConfigController::class, 'limpiar'])->name('admin.limpiar');
    Route::delete('/admin/restablecer', [ConfigController::class, 'restablecer'])->name('admin.restablecer');
    Route::get('/admin/usuarios/create', [ConfigController::class, 'createUsuario'])->name('admin.usuarios.create');
    Route::post('/admin/categorias', [ConfigController::class, 'storeCategoria'])->name('admin.categorias.store');
    Route::delete('/admin/categorias/{id}', [ConfigController::class, 'destroyCategoria'])->name('admin.categorias.destroy');
    Route::get('/admin/exportar', [ConfigController::class, 'exportar'])->name('admin.exportar');

    // Buzón
    Route::get('/buzon', [BuzonController::class, 'index'])->name('buzon.index');
    Route::post('/buzon', [BuzonController::class, 'store'])->name('buzon.store');
    Route::put('/buzon/{id}', [BuzonController::class, 'update'])->name('buzon.update');
    Route::patch('/buzon/{id}/anular', [BuzonController::class, 'anular'])->name('buzon.anular');
    Route::get('/buzon/folio/{folio}', [BuzonController::class, 'porFolio'])->name('buzon.folio');
    Route::get('/buzon/todos', [BuzonController::class, 'indexTodos'])->name('buzon.todos');
});

// 🔴 ADMIN ONLY
Route::middleware(['auth', 'admin', 'nocache'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::view('/', 'admin')->name('index');

        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
        Route::get('/buzon', [BuzonAdminController::class, 'index'])->name('buzon.index');
        Route::get('/buzon/{id}', [BuzonAdminController::class, 'show'])->name('buzon.show');
        Route::patch('/buzon/{id}/estado', [BuzonAdminController::class, 'updateEstado'])->name('buzon.estado');
        Route::patch('/buzon/{id}/anular', [BuzonAdminController::class, 'anular'])->name('buzon.anular');
    });

// 🎓 ALUMNO
Route::middleware(['auth', 'alumno', 'nocache'])->group(function () {
    Route::get('/alumno/dashboard', [AlumnoDashboardController::class, 'index'])->name('alumno.dashboard');
});

// 🎓 DIRECTOR
Route::middleware(['auth', 'director', 'nocache'])
    ->prefix('director')
    ->name('director.')
    ->group(function () {
        Route::get('/dashboard', [DirectorController::class, 'index'])->name('dashboard');
        Route::get('/detalle/{id}', [DirectorController::class, 'show'])->name('detalle');
        Route::get('/exportar', [DirectorController::class, 'exportar'])->name('exportar');
    });

// 🎓 SUBDIRECTOR
Route::middleware(['auth', 'subdirector', 'nocache'])
    ->prefix('subdirector')
    ->name('subdirector.')
    ->group(function () {
        Route::get('/dashboard', [SubdirectorController::class, 'index'])->name('dashboard');
        Route::get('/detalle/{id}', [SubdirectorController::class, 'show'])->name('detalle');
        Route::get('/exportar', [SubdirectorController::class, 'exportar'])->name('exportar');
    });

require __DIR__ . '/auth.php';
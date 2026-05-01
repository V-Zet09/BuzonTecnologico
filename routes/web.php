<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegistroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

// 🔴 Redirección raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// 🟢 REGISTRO (público)
Route::get('/registro', [RegistroController::class, 'create'])->name('registro');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');

// 🟡 DASHBOARD (solo autenticados)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 🟢 RUTAS SOLO AUTH (usuario logueado)
Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paneles normales
    Route::view('/ventas', 'ventas')->name('ventas');
    Route::view('/productos', 'productos')->name('productos');
});


// 🔴 ADMIN ONLY (PROTEGIDO CON TU MIDDLEWARE)
Route::middleware(['auth', 'admin'])->group(function () {

    Route::view('/admin', 'admin')->name('admin');

    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::post('/admin/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('/admin/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/admin/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

});

require __DIR__.'/auth.php';
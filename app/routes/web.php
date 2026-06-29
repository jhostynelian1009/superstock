<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminAccessRequestController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\InventoryMovementController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Raíz → dashboard si autenticado, login si invitado
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register/admin', [AdminRegistrationController::class, 'create'])->name('register.admin');
    Route::post('/register/admin', [AdminRegistrationController::class, 'store']);
    Route::get('/register/admin/verify', [AdminRegistrationController::class, 'showVerify'])->name('register.admin.verify');
    Route::post('/register/admin/verify', [AdminRegistrationController::class, 'verify']);
});

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

// ── Panel Administrativo ────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::post('/usuarios/{usuario}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.usuarios.toggle-status');
    Route::post('/usuarios/{usuario}/permissions', [UserController::class, 'updatePermissions'])->name('admin.usuarios.update-permissions');
    Route::get('/configuracion', fn () => redirect()->route('admin.dashboard', ['panel' => 'configuracion']))
        ->name('admin.configuracion.index');

    Route::middleware('primary_admin')->group(function () {
        Route::get('/solicitudes-admin', [AdminAccessRequestController::class, 'index'])->name('admin.solicitudes-admin.index');
        Route::post('/solicitudes-admin/{solicitud}/aprobar', [AdminAccessRequestController::class, 'approve'])->name('admin.solicitudes-admin.approve');
        Route::post('/solicitudes-admin/{solicitud}/rechazar', [AdminAccessRequestController::class, 'reject'])->name('admin.solicitudes-admin.reject');
        Route::post('/solicitudes-admin/{solicitud}/reenviar', [AdminAccessRequestController::class, 'resend'])->name('admin.solicitudes-admin.resend');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categorias', CategoryController::class)
        ->parameters(['categorias' => 'categoria'])
        ->except(['show']);
    Route::resource('productos', ProductController::class)
        ->parameters(['productos' => 'producto'])
        ->except(['show']);
    Route::resource('proveedores', SupplierController::class)
        ->parameters(['proveedores' => 'proveedor'])
        ->except(['show']);
    Route::get('inventario', [InventoryController::class, 'index'])->name('inventario.index');
    Route::resource('movimientos', InventoryMovementController::class)
        ->parameters(['movimientos' => 'movimiento'])
        ->only(['index', 'create', 'store', 'show']);
});

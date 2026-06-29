<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Admin\AdminAccessRequestController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InventoryMovementController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'landing'])->name('landing');
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/{slug}', [CatalogController::class, 'show'])->name('catalogo.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register/admin', [AdminRegistrationController::class, 'create'])->name('register.admin');
    Route::post('/register/admin', [AdminRegistrationController::class, 'store']);
    Route::get('/register/admin/verify', [AdminRegistrationController::class, 'showVerify'])->name('register.admin.verify');
    Route::post('/register/admin/verify', [AdminRegistrationController::class, 'verify']);
});

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/cart', [WhatsAppController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add/{id}', [WhatsAppController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [WhatsAppController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [WhatsAppController::class, 'clearCart'])->name('cart.clear');

Route::middleware(['auth', 'client'])->group(function () {
    Route::post('/checkout/whatsapp', [WhatsAppController::class, 'checkoutWhatsApp'])->name('checkout.whatsapp');
    Route::get('/pedido/confirmacion', [WhatsAppController::class, 'orderSuccess'])->name('checkout.success');

    Route::prefix('mi-cuenta')->name('client.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/perfil', [ClientProfileController::class, 'edit'])->name('perfil.edit');
        Route::put('/perfil', [ClientProfileController::class, 'update'])->name('perfil.update');
        Route::get('/pedidos', [ClientOrderController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}', [ClientOrderController::class, 'show'])->name('pedidos.show');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/proveedores', fn () => view('admin.placeholders.coming-soon', [
        'title' => 'Proveedores',
        'breadcrumb' => 'Proveedores',
        'description' => 'Gestión de proveedores del inventario.',
    ]))->name('admin.proveedores.index');
    Route::get('/inventario', fn () => view('admin.placeholders.coming-soon', [
        'title' => 'Inventario',
        'breadcrumb' => 'Inventario',
        'description' => 'Consulta de existencias y condiciones de abastecimiento.',
    ]))->name('admin.inventario.index');
    Route::get('/movimientos', fn () => view('admin.placeholders.coming-soon', [
        'title' => 'Movimientos',
        'breadcrumb' => 'Movimientos',
        'description' => 'Historial de entradas y salidas de inventario.',
    ]))->name('admin.movimientos.index');
    Route::get('/pedidos', [AdminOrderController::class, 'index'])->name('admin.pedidos.index');
    Route::get('/pedidos/{pedido}', [AdminOrderController::class, 'show'])->name('admin.pedidos.show');
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/configuracion', fn () => redirect()->route('admin.dashboard', ['panel' => 'configuracion']))
        ->name('admin.configuracion.index');

    Route::middleware('primary_admin')->group(function () {
        Route::get('/solicitudes-admin', [AdminAccessRequestController::class, 'index'])->name('admin.solicitudes-admin.index');
        Route::post('/solicitudes-admin/{solicitud}/aprobar', [AdminAccessRequestController::class, 'approve'])->name('admin.solicitudes-admin.approve');
        Route::post('/solicitudes-admin/{solicitud}/rechazar', [AdminAccessRequestController::class, 'reject'])->name('admin.solicitudes-admin.reject');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categorias', CategoryController::class)
        ->parameters(['categorias' => 'categoria'])
        ->except(['show']);
    Route::resource('productos', ProductController::class)
        ->parameters(['productos' => 'producto'])
        ->except(['show']);
<<<<<<< HEAD
    Route::resource('proveedores', SupplierController::class)
        ->parameters(['proveedores' => 'proveedor'])
        ->except(['show']);
    Route::get('inventario', [InventoryController::class, 'index'])->name('inventario.index');
=======
    Route::resource('movimientos', InventoryMovementController::class)
        ->parameters(['movimientos' => 'movimiento']);
>>>>>>> Amy-Villalva
});


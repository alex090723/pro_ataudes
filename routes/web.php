<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
//use App\Http\Controllers\ReportesController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\MailController;

use App\Http\Controllers\ObjetoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



require __DIR__.'/auth.php';



Auth::routes(['verify' => true]);


// Rutas para modulo de seguridad

Route::group(['middleware' => ['auth']], function(){
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    
});

// Rutas para modulo de backup
use App\Http\Controllers\BackupController;

Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('/backup/create', [BackupController::class, 'createBackup'])->name('backup.create');
Route::post('/backup/schedule', [BackupController::class, 'scheduleBackup'])->name('backup.schedule');
Route::post('/backup/restore', [BackupController::class, 'restoreBackup'])->name('backup.restore');


// Rutas para modulo de permisos
use App\Http\Controllers\PermisosController;

Route::middleware(['auth'])->group(function () {
    Route::get('/permisos', [PermisosController::class, 'index'])->name('permisos.index');
    Route::put('/permisos', [PermisosController::class, 'update'])->name('permisos.update');
    Route::get('/roles/{id}/permissions', [PermisosController::class, 'getPermissions']);
});

// Rutas para reportes

//Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index')->middleware('auth');
//Route::post('/reportes', [ReportesController::class, 'store'])->name('reportes.store')->middleware('auth');
//Route::put('/reportes/{id}', [ReportesController::class, 'update'])->name('reportes.update')->middleware('auth');
// Rutas para usuarios
Route::get('/users', [UserController::class, 'index'])->middleware('auth');
Route::post('/desbloquear-usuario', [UserController::class, 'desbloquearUsuario'])->name('desbloquear-usuario')->middleware('auth');
Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role')->middleware('auth');


// Rutas para personas
use App\Http\Controllers\PersonasController;
Route::get('/personas', [PersonasController::class, 'index'])->name('personas.index')->middleware('auth');
Route::post('/personas', [PersonasController::class, 'store'])->name('personas.store')->middleware('auth');
Route::put('/personas/{id}', [PersonasController::class, 'update'])->name('personas.update')->middleware('auth');


// Rutas de autenticación y recuperación de contraseña
Auth::routes();

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Ruta del contrsena temporal
use App\Http\Controllers\Auth\RegisteredUserController;

Route::group(['middleware' => ['auth', 'check.temporary.password']], function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');
    // Otras rutas
});
Route::get('/password/change', [RegisteredUserController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/password/change', [RegisteredUserController::class, 'changePassword'])->name('password.update');

// Ruta para el registro
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

// Rutas para cambiar la contraseña
Route::get('/change-password', [RegisteredUserController::class, 'showChangePasswordForm'])->middleware('auth')->name('password.change');
Route::post('/change-password', [RegisteredUserController::class, 'changePassword'])->middleware('auth')->name('password.change.submit');



// Ruta para Email
Route::get('/send-test-mail', [MailController::class, 'sendTestMail']);

// Ruta para reportes
use App\Http\Controllers\ReportesController;                                                                  Route::get('/reportes', [ReportesController::class, 'index'])->name('report.index');
Route::get('/reporte', [ReportesController::class, 'index'])->name('report.index');
Route::get('/reporte/generar', [ReportesController::class, 'generate'])->name('report.generate');
Route::get('/reportes/personas', [ReportesController::class, 'getPersonasData'])->name('report.generate.personas');
Route::get('/generar-reporte', [ReportesController::class, 'generarReporte'])->name('generar.reporte');




/// modulo inventario 

use App\Http\Controllers\InventarioMaterialesController;

Route::get('/inventario_materiales', [InventarioMaterialesController::class, 'index'])->name('Materiales.index');
Route::post('/inventario_materiales', [InventarioMaterialesController::class, 'store'])->name('Materiales.store');
Route::put('/inventario_materiales/{id}', [InventarioMaterialesController::class, 'update'])->name('Materiales.update');


// rutas para carrozas 
use App\Http\Controllers\CarrozasController;
Route::resource('carrozas', CarrozasController::class);
Route::get('Carrozas', [CarrozasController::class, 'index'])->name('Carrozas.index');
Route::post('Carrozas', [CarrozasController::class, 'store'])->name('Carrozas.store');
Route::put('Carrozas/{id}', [CarrozasController::class, 'update'])->name('Carrozas.update');


// Rutas para Producto
use App\Http\Controllers\ProductoController;
Route::resource('Productos', ProductoController::class);
Route::get('/Productos', [ProductoController::class, 'index'])->name('Productos.index');
Route::post('/Productos', [ProductoController::class, 'store'])->name('Productos.store');
Route::put('Productos/{id}', [ProductoController::class, 'update'])->name('Productos.update');


// VENTAS 
use App\Http\Controllers\VentaController;

// Ruta para la lista de ventas
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');

// Ruta para almacenar una nueva venta
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');

// Ruta para mostrar el formulario de edición de una venta
Route::get('/ventas/{id}/edit', [VentaController::class, 'edit'])->name('ventas.edit');

// Ruta para actualizar una venta

Route::put('/ventas/{id}', [VentaController::class, 'update'])->name('ventas.update');


use App\Http\Controllers\HistorialPagosController;

Route::get('/historial_pagos', [HistorialPagosController::class, 'index'])->name('historial_pagos.index');
Route::post('/historial_pagos', [HistorialPagosController::class, 'store'])->name('historial_pagos.store');
Route::get('/historial_pagos/{id}/edit', [HistorialPagosController::class, 'edit'])->name('historial_pagos.edit');
Route::put('/historial_pagos/{id}', [HistorialPagosController::class, 'update'])->name('historial_pagos.update');
Route::get('/historial_pagos/buscar', [HistorialPagosController::class, 'buscarPorNombre'])->name('historial_pagos.buscar');
Route::get('historial_pagos/imprimir', [HistorialPagosController::class, 'imprimirHistorial'])->name('historial_pagos.imprimir');





use App\Http\Controllers\PlanPagoController;

// Rutas para PlanPago
Route::get('plan_pago', [PlanPagoController::class, 'index'])->name('plan_pago.index');
Route::post('plan_pago', [PlanPagoController::class, 'store'])->name('plan_pago.store');
Route::get('/plan_pago/{id}/edit', [PlanPagoController::class, 'edit'])->name('plan_pago.edit');
Route::put('plan_pago/{id}', [PlanPagoController::class, 'update'])->name('plan_pago.update');




use App\Http\Controllers\CuentaPorCobrarController;

Route::get('/cuentasPorCobrar', [CuentaPorCobrarController::class, 'index'])->name('cuentasPorCobrar.index');
Route::post('/cuentasPorCobrar', [CuentaPorCobrarController::class, 'store'])->name('cuentasPorCobrar.store');
Route::get('/cuentasPorCobrar/{id}/edit', [CuentaPorCobrarController::class, 'edit'])->name('cuentasPorCobrar.edit');
Route::put('/cuentasPorCobrar/{id}', [CuentaPorCobrarController::class, 'update'])->name('cuentasPorCobrar.update');


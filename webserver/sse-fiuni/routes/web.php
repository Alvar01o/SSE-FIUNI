<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EgresadoController;
use App\Http\Controllers\EmpleadorController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\CarrerasController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/registro', RegistroController::class);
Route::post('/registro', RegistroController::class);

Route::get('/', LoginController::class);
Route::get('/login', LoginController::class);
Route::get('/logout', LogoutController::class);
Route::post('/login', LoginController::class);
/**
 * Rutas personalizadas de administrador
 */
Route::get('/egresado/lista', [EgresadoController::class, 'lista'])->name('egresado.lista');

Route::resource('reportes', ReportesController::class);
Route::resource('admin', AdminController::class);
Route::resource('egresado', EgresadoController::class);
Route::resource('empleador', EmpleadorController::class);
Route::resource('carreras', CarrerasController::class);
Route::post('/carreras/store', [CarrerasController::class, 'store'])->name('carreras.store');
Route::post('/carreras/destroy/{id}', [CarrerasController::class, 'destroy'])->name('carreras.destroy');

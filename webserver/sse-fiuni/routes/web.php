<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EgresadoController;
use App\Http\Controllers\EmpleadorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', LoginController::class);
Route::get('/login', LoginController::class);
Route::get('/logout', LogoutController::class);
Route::post('/login', LoginController::class);
Route::resource('admin', AdminController::class);
Route::resource('egresado', EgresadoController::class);
Route::resource('empleador', EmpleadorController::class);

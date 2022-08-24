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
use App\Http\Controllers\UploadAvatarController;
use App\Http\Controllers\EncuestasController;

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
Route::get('/empleador/lista', [EmpleadorController::class, 'lista'])->name('empleador.lista');

Route::resource('reportes', ReportesController::class);
Route::resource('admin', AdminController::class);
Route::resource('egresado', EgresadoController::class);
Route::resource('empleador', EmpleadorController::class);
Route::resource('carreras', CarrerasController::class);


Route::get('/egresado/{id}/perfil', [EgresadoController::class, 'perfil'])->name('egresado.perfil');
Route::get('/perfil', [EgresadoController::class, 'perfil'])->name('perfil');
Route::get('/perfil/editar', [EgresadoController::class, 'editar_perfil'])->name('perfil.editar');
Route::get('/perfil/{id}/editar', [EgresadoController::class, 'editar_perfil'])->name('perfil.editar');

Route::group(['middleware' => ['sessionChecked']], function () {
    //upload image url  - remove id
    Route::post('/upload_avatar', UploadAvatarController::class);
    Route::get('/get_avatar', [EgresadoController::class, 'get_avatar'])->name('get_avatar');
    Route::get('/get_avatar/{id}', [EgresadoController::class, 'get_avatar'])->name('get_avatar2');

    //guardar datos laborales
    Route::post('/egresado/laboral', [EgresadoController::class, 'add_laboral'])->name('add_laboral');
    Route::post('/egresado/laboral/{id}', [EgresadoController::class, 'add_laboral'])->name('add_laboral_param');
    Route::post('/egresado/educacion/{id}', [EgresadoController::class, 'add_educacion'])->name('add_educacion_param');
    Route::post('/cambiarpassword/{id}', [EgresadoController::class, 'new_pass'])->name('new_pass');
    Route::get('/empleadores/json', [EmpleadorController::class, 'json'])->name('empleadores_json_complete');
    Route::get('/empleadores/json/{query}', [EmpleadorController::class, 'json'])->name('empleadores_json');
    Route::get('/elimiar_dato_laboral/{id}', [EgresadoController::class, 'elimiar_dato_laboral'])->name('perfil.elimiar_dato_laboral');
    Route::get('/elimiar_educacion/{id}', [EgresadoController::class, 'elimiar_educacion'])->name('perfil.elimiar_educacion');

    // encues=
    Route::post('/encuestas/add_pregunta', [EncuestasController::class, 'addPregunta'])->name('addPregunta');
    Route::get('/encuestas/asignados', [EncuestasController::class, 'asignados'])->name('asignados');
    Route::post('/encuestas/add_usuarios/{id}', [EncuestasController::class, 'addUsuarios'])->name('addUsuarios');
    Route::resource('encuestas', EncuestasController::class);
});

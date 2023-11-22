<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitacionesController;

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





/* ---------------------------------------------------------------------------------------------- */
/*                                          Autenticacion                                         */
/* ---------------------------------------------------------------------------------------------- */

Auth::routes(
    [
        'register' => false, // Deshabilita el registro de usuarios
        'reset' => false,   // Deshabilita la recuperacion de contraseña
        'verify' => false,  // Deshabilita la verificacion de correo
    ]

);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/* ---------------------------------------------------------------------------------------------- */
/*                                            DASHBOARD                                           */
/* ---------------------------------------------------------------------------------------------- */


Route::get('/', [\App\Http\Controllers\EventoController::class, 'index'])->middleware('auth');


/* ------------------------------------------- EVENTOS ------------------------------------------ */
Route::post('/eventos', [App\Http\Controllers\EventoController::class, 'getEventos'])->middleware('auth');
Route::get('/eventos/{evento}', [App\Http\Controllers\EventoController::class, 'details'])->middleware('auth');

/* ------------------------------------------ INVITADOS ----------------------------------------- */
Route::post('/invitados', [App\Http\Controllers\InvitadoController::class, 'getInvitados'])->middleware('auth');
Route::post('/invitados/create', [App\Http\Controllers\InvitadoController::class, 'create']);


/* ------------------------------------------- INVITACIONES  ------------------------------------------ */
Route::prefix('/invitaciones')->group(function () {
    Route::get('/index', [InvitacionesController::class, 'index'])->middleware('auth')->name('invitaciones.index');
    Route::post('/agregarInvitacion', [InvitacionesController::class, 'agregarInvitacion'])->middleware('auth');
    Route::get('/{invitacion}', [InvitacionesController::class, 'show'])->name('invitaciones.show');
});
/* ------------------------------------------- QRCODES ------------------------------------------ */
Route::get('/qrcodes/generate', [App\Http\Controllers\QrController::class, 'generate'])->middleware('auth');
Route::get('/qrcode/invitacion/{invitado}', [App\Http\Controllers\QrController::class, 'invitacion']);

/* ------------------------------------------- ARTISAN ------------------------------------------ */
Route::get('/artisan_2486migrate', [App\Http\Controllers\ArtisanController::class, 'migrate']);

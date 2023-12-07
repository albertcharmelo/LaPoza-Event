<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitacionesController;
use App\Http\Controllers\EventoController;
use App\Mail\SendUrlInvitacion;
use Illuminate\Support\Facades\Mail;

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
Route::get('/eventos/{evento}/{detalle}', [App\Http\Controllers\EventoController::class, 'details'])->middleware('auth');
Route::post('/eventos/changeStatus', [EventoController::class, 'changeStatus'])->middleware('auth');

/* ------------------------------------------ INVITADOS ----------------------------------------- */
Route::post('/invitados', [App\Http\Controllers\InvitadoController::class, 'getInvitados'])->middleware('auth');
Route::post('/invitados/create', [App\Http\Controllers\InvitadoController::class, 'create']);


/* ------------------------------------------- INVITACIONES  ------------------------------------------ */
Route::prefix('/invitaciones')->group(function () {
    Route::get('/index', [InvitacionesController::class, 'index'])->middleware('auth')->name('index');
    Route::post('/getInvitaciones', [InvitacionesController::class, 'getInvitaciones'])->middleware('auth');
    Route::get('/create', [InvitacionesController::class, 'create'])->middleware('auth')->name('invitaciones.create');
    Route::get('/edit/{invitacion}', [InvitacionesController::class, 'edit'])->middleware('auth')->name('invitaciones.edit');
    Route::post('/actualizarInvitacion', [InvitacionesController::class, 'actualizarInvitacion'])->middleware('auth');
    Route::post('/agregarInvitacion', [InvitacionesController::class, 'agregarInvitacion'])->middleware('auth');
    Route::get('/{invitacion}', [InvitacionesController::class, 'show'])->name('invitaciones.show');
    Route::post('/crearPlantilla', [InvitacionesController::class, 'crearPlantilla'])->middleware('auth');
    Route::post('/getPlantillas', [InvitacionesController::class, 'getPlantillas'])->middleware('auth');
    Route::post('/getPlatos', [InvitacionesController::class, 'getPlatos'])->middleware('auth');
    Route::post('/getDetallesPlantilla', [InvitacionesController::class, 'getDetallesPlantilla'])->middleware('auth');
    Route::post('/getInvitadosByPlatos', [InvitacionesController::class, 'getInvitadosByPlato'])->middleware('auth');
    Route::post('/eliminarDocumento', [InvitacionesController::class, 'eliminarDocumento'])->middleware('auth');
    Route::post('/agregarDocumento', [InvitacionesController::class, 'agregarDocumento'])->middleware('auth');
    Route::post('/updateImagenMenu', [InvitacionesController::class, 'updateImagenMenu'])->middleware('auth');
    Route::post('/enviarInvitacionMail', [InvitacionesController::class, 'enviarInvitacionMail'])->middleware('auth');
});
/* ------------------------------------------- QRCODES ------------------------------------------ */
Route::get('/qrcodes/generate', [App\Http\Controllers\QrController::class, 'generate'])->middleware('auth');
Route::get('/qrcode/invitacion/{invitado}', [App\Http\Controllers\QrController::class, 'invitacion']);

/* ------------------------------------------- ARTISAN ------------------------------------------ */
Route::get('/artisan_2486migrate', [App\Http\Controllers\ArtisanController::class, 'migrate']);


/* -------------------------------------- EJEMPLO DE CORREO ------------------------------------- */
Route::get('/correo', function () {
    $url_invitacion = 'http://localhost:8000/invitaciones/1';
    Mail::to('acharmelo99@gmail.com')->send(new SendUrlInvitacion($url_invitacion));
    return 'Correo enviado';
});

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});



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

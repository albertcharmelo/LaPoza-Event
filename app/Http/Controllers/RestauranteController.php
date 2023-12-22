<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    public static function getRestaurantes()
    {
        $restaurantes = Restaurante::all();
        return $restaurantes;
    }
}

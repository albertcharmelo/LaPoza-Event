<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UtilController extends Controller
{
    /**
     * Crea una imagen en formato base64 a partir de una imagen enviada en una petición.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public static function crearImagenBase64(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagen' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($validator->fails()) {
            return null;
        }
        $imagen = $request->file('imagen');
        $imagen_base64 = null;
        if ($imagen) {
            $imagen_base64 = base64_encode(file_get_contents($imagen));
        }
        return $imagen_base64;
    }
}

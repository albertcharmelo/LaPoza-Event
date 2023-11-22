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


    public static function curl($URL, $POSTFIELDS, $TOKEN)
    {
        // This code makes a curl request to an API endpoint.

        // The first line initializes a curl handle.
        $curl = curl_init();

        // The second line sets the curl options.
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL, // The URL of the API endpoint.
            CURLOPT_RETURNTRANSFER => true, // Indicates that the response should be returned as a string.
            CURLOPT_ENCODING => '', // The HTTP encoding to use.
            CURLOPT_MAXREDIRS => 10, // The maximum number of redirects to follow.
            CURLOPT_TIMEOUT => 0, // The timeout in seconds.
            CURLOPT_FOLLOWLOCATION => true, // Indicates that redirects should be followed.
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // The HTTP version to use.
            CURLOPT_CUSTOMREQUEST => 'POST', // The HTTP request method to use.
            CURLOPT_POSTFIELDS => $POSTFIELDS, // The POST fields to send.
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $TOKEN // The authorization header.
            ),
        ));

        // The third line executes the curl request.
        $response = curl_exec($curl);

        // The fourth line closes the curl handle.
        curl_close($curl);

        // The fifth line returns the response.
        return $response;
    }
}

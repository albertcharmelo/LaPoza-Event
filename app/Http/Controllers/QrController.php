<?php

namespace App\Http\Controllers;

use App\Models\CodigoQr;
use App\Models\Invitacion;
use App\Models\Invitado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class QrController extends Controller
{

    /**
     * Genera un código QR y lo guarda en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse $qr_code_created
     */



    public static function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invitado_id' => 'required | string',
            'invitacion_id' => 'required | string',
            'value' => 'required | string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 400);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://storage.worki.es/api/generarQr',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'text=hola',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer 14|AZ5DTvY8f24NEnHLAFywyUIiuDlC2zQWBZArlWbz'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $qrCode = base64_encode($response);
        dd($qrCode);
        $qr_code_created = CodigoQr::create([
            'invitado_id' => $request->invitado_id,
            'invitacion_id' => $request->invitacion_id,
            'path' => $qrCode
        ]);

        return $qr_code_created;
    }

    public static function invitacion(Invitado $invitado)
    {


        $page_title = 'Invitacion';
        $invitado->platos_elegidos = explode('*', $invitado->platos_elegidos);
        return view('pages.invitacion.qr', compact('invitado', 'page_title'));
    }
}

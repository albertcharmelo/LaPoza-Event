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

        $qrCode = QrCode::format('png')
            ->size(200)

            ->generate($request->value);

        $qr_code_created = CodigoQr::create([
            'invitado_id' => $request->invitado_id,
            'invitacion_id' => $request->invitacion_id,
            'path' => base64_encode($qrCode)
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

<?php

namespace App\Http\Controllers;

use App\Models\Invitado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class InvitadoController extends Controller
{
    public function create(Request $request)
    {
        $telefono = '';
        if ($request->datos_requeridos == 1 || $request->datos_requeridos == 'true' || $request->datos_requeridos == '1') {
            $validation = Validator::make($request->all(), [
                'datos_requeridos' => 'required | boolean',
                'nombre' =>  ' required | string',
                'telefono' => 'required |string',
                'invitados' => 'required | integer | min:1',
                'evento_id' => 'required | string',
                'invitacion_id' => 'required | string',
                'platos' => '  array',
            ]);

            $telefono = $request->telefono;
        } else {
            $validation = Validator::make($request->all(), [
                'datos_requeridos' => 'required | boolean',
                'nombre' =>  ' required | string',
                'invitados' => 'required | integer | min:1',
                'evento_id' => 'required | string',
                'invitacion_id' => 'required | string',
                'platos' => '  array',
            ]);

            $telefono = 'No disponible';
        }




        if ($validation->fails()) {
            return response()->json([
                'message' => $validation->errors()->first()
            ], 400);
        }

        $platos_elegidos  = json_encode($request->platos);



        $invitado = Invitado::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'nif' => '30798427',
            'telefono' => $telefono,
            'numero_personas' => $request->invitados,
            'observaciones' => $request->observaciones,
            'evento_id' => $request->evento_id,
            'invitacion_id' => $request->invitacion_id,
            'platos_elegidos' => $platos_elegidos,
        ]);

        $request_to_qrCode = new Request([
            'invitado_id' => $invitado->id,
            'invitacion_id' => $request->invitacion_id,
            'value' => $invitado->id,
        ]);

        $created_qrCode = QrController::generate($request_to_qrCode);
        $invitado->codigoQr = $created_qrCode;
        return response()->json($invitado, 200);
    }

    public function getInvitados(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'evento_id' => 'required | string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => $validation->errors()->first()
            ], 400);
        }

        $evento_id = $request->evento_id;
        $invitados = Invitado::where('evento_id', $evento_id)->orderBy('asistencia_confirmada', 'desc')->get();

        return response()->json(

            $invitados,
            200
        );
    }
}

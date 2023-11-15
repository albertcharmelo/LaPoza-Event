<?php

namespace App\Http\Controllers;

use App\Models\Invitado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class InvitadoController extends Controller
{
    public function create(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'nombre' => 'required | string',
            'email' => 'required | string',
            'telefono' => ' string',
            'invitados' => 'required | integer | min:1',
            'observaciones' => 'string',
            'evento_id' => 'required | string',
            'invitacion_id' => 'required | string',
            'platos' => 'required | array',
            'platos.*' => 'required | string',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'message' => $validation->errors()->first()
            ], 400);
        }

        $palatos_elegidos  = implode(',', $request->platos);
        $invitado = Invitado::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'nif' => '30798427',
            'telefono' => $request->telefono,
            'numero_personas' => $request->invitados,
            'observaciones' => $request->observaciones,
            'evento_id' => $request->evento_id,
            'invitacion_id' => $request->invitacion_id,
            'menu' => $palatos_elegidos,
        ]);

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

<?php

namespace App\Http\Controllers;

use App\Models\Invitado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class InvitadoController extends Controller
{
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

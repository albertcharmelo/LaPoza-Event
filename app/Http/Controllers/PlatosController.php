<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Invitado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlatosController extends Controller
{
    static public function exportarPlatos($evento_id)
    {

        $evento = Evento::find($evento_id);
        $platos_invitados = Invitado::where('evento_id', $evento_id)->get(['platos_elegidos', 'numero_personas']);
        $platos = [];

        foreach ($platos_invitados as $platos_elegidos_string) {
            $plato_decode = json_decode($platos_elegidos_string->platos_elegidos);
            $cantidadComensalesPInvitacion = $platos_elegidos_string->numero_personas;

            foreach ($plato_decode as $key => $platos_del_invitado) {

                foreach ($platos_del_invitado as $titulo => $plato) {
                    $data = [
                        'titulo' => $titulo, // entrante ,segundo , postre ...
                        'plato' => $plato,
                        'cantidad' => $cantidadComensalesPInvitacion,
                    ];

                    $platos[] = $data;
                }
            }
        }

        // agrupar por plato y sumar cantidad de comensales
        $platos = collect($platos)->groupBy('plato')->map(function ($row) {
            return [
                'titulo' => $row[0]['titulo'],
                'plato' => $row[0]['plato'],
                'cantidad' => $row->sum('cantidad'),
            ];
        })->values();

        // agrupar platos por titulo 
        $platos = collect($platos)->groupBy('titulo')->map(function ($row) {
            return [
                'titulo' => $row[0]['titulo'],
                'platos' => $row,
            ];
        })->values();

        //parsear a array
        $platos = $platos->toArray();

        $data = [
            'platos' => $platos,
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('export.platospdf', $data)
            ->download($evento->invitacion->titulo . '.pdf');
    }
}

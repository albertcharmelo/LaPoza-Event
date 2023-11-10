<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Panel';

        return view('pages.eventos.index', compact('page_title'));
    }

    public static function getEventos()
    {
        if (Auth::check()) {

            $eventos = Evento::get()->toArray();
            $eventos = array_map(
                function ($evento) {
                    $evento['fecha'] = date('d-m-Y', strtotime($evento['fecha']));
                    $evento['ingreso_bruto'] = '€' . number_format($evento['ingreso_bruto'], 0, ',', '.');
                    return $evento;
                },
                $eventos
            );
            return response()->json($eventos, 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Controlador para la gestión de eventos.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $page_title = 'Panel';

        return view('pages.eventos.index', compact('page_title'));
    }

    /**
     * Obtiene todos los eventos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getEventos()
    {
        if (Auth::check()) {

            $eventos = Evento::with('invitacion')->get()->toArray();            
            $eventos = array_map(
                function ($evento) {
                    $evento['fecha'] = date('d-m-Y', strtotime($evento['fecha']));
                    $evento['ingreso_bruto'] = '€' . number_format($evento['ingreso_bruto'], 0, ',', '.');
                    $evento['comensales'] = array_reduce(
                        $evento['invitados'],
                        function ($carry, $invitado) {
                            if ($invitado['numero_personas'] > 0) {
                                $carry += $invitado['numero_personas'];
                            }
                            return $carry;
                        },
                        0
                    );
                    $evento['invitacion'] = $evento['invitacion'];
                    return $evento;
                },
                $eventos
            );
            return response()->json($eventos, 200);
        }
    }

    /**
     * Muestra los detalles de un evento.
     *
     * @param Evento $evento
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(Evento $evento, $detalle)
    {
        $page_title = $evento->nombre . ' - Detalles';
        $evento->ingreso_bruto = '€' . number_format($evento->ingreso_bruto, 0, ',', '.');
        return view('pages.eventos.show', compact('evento', 'page_title', 'detalle'));
    }

    public function changeStatus(Request $request)
    {
        $Evento = Evento::where('id', '=', $request->id)->first();
        $Evento->status = $request->status;
        $Evento->save();
        return response()->json([
            "menssaje" => "Status actualizado",
            'data' => $Evento
        ], 200);
    }
}

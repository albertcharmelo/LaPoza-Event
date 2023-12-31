<?php

namespace App\Http\Controllers;

use App\Models\PlatillaMenu;
use Illuminate\Http\Request;

class PlantillaController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Panel';

        return view('pages.plantillas.index', compact('page_title'));
    }

    public function getAllPlantillas(Request $request)
    {
        $plantillas = PlatillaMenu::all()->toArray();

        $plantillas = array_map(
            function ($plantilla) {
                $plantilla['tipo_plantilla'] = "Platos - " . $plantilla['tipo_menu'];
                return $plantilla;
            },
            $plantillas
        );

        return response()->json($plantillas);
    }

    public function plantillaPlatos(PlatillaMenu $plantilla)
    {
        $page_title = $plantilla->name;
        return view('pages.plantillas.platos', compact('plantilla', 'page_title'));
    }

    public function crearPlantilla(Request $request, $tipo)
    {
        $page_title = 'Crear Plantilla';
        if ($tipo == 'platos') {
            return view('pages.plantillas.crear_plantilla_platos', compact('page_title'));
        } else {
            return view('pages.plantillas.crear_plantilla_evento', compact('page_title'));
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invitacion;
use App\Models\Evento;
use App\Models\Imagen;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Http\Controllers\UtilController;
use App\Mail\SendUrlInvitacion;
use App\Models\Invitado;
use App\Models\PlatillaMenu;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class InvitacionesController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Invitaciones';

        return view('pages.invitacion.index', compact('page_title'));
    }

    public function getInvitaciones(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'No autorizado',
            ], 401);
        }
        try {

            $invitaciones = Invitacion::select('id', 'titulo', 'tipo_menu', 'updated_at', 'evento_id')
                ->with('evento:id,nombre,fecha')
                ->orderBy('updated_at', 'desc')
                ->get();

            // Formatea updated_at para cada invitacion
            $invitaciones->map(function ($invitacion) {
                $invitacion->updated_at_formatted = Carbon::parse($invitacion->updated_at)->format('d/m/Y');
                $invitacion->evento->fecha_formatted = Carbon::parse($invitacion->evento->fecha)->format('d/m/Y');
                return $invitacion;
            });

            return response()->json($invitaciones, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las invitaciones: ' . $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al obtener las invitaciones: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function create(Request $request)
    {
        $page_title = 'Invitaciones';
        $invitacion = null;
        $title = 'Crear Invitación';
        return view('pages.invitacion.create', compact('page_title', 'invitacion', 'title'));
    }

    public function agregarInvitacion(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required',
                'descripcion' => 'required',
                'tipoMenu' => 'required',
                'files' => 'required|array|min:1',
                'nombre_org' => 'required',
                'email_org' => 'required'
            ]);

            foreach ($request->input('files') as $index => $file) {
                $imagen_base64 = substr($file['base64'], strpos($file['base64'], ",") + 1);
                $sizeInMb = (strlen($imagen_base64) * 3 / 4) / (1024 * 1024);
                if ($sizeInMb > 16) {
                    return response()->json([
                        'message' => 'El tamaño de la imagen no puede ser mayor a 16MB',
                    ], 400);
                }
            }

            $creado_por = auth()->user()->id;

            $imagen = $request->input('file_menu.base64');
            $imagen = substr($imagen, strpos($imagen, ",") + 1);
            $imagen_nombre = $request->input('file_menu.nombre');

            DB::beginTransaction();
            $evento = Evento::create([
                'nombre' => $validatedData['nombre_org'],
                'email_organizador' => $validatedData['email_org'],
                'telefono_organizador' => $request->telefono_org,
                'numero_invitados' => 0,
                'ingreso_bruto' => 0,
                'fecha' => $request->fecha_evento,
                'creado_por' => $creado_por,
            ]);
            $invitacion = Invitacion::create([
                'titulo' => $validatedData['titulo'],
                'texto' =>  $validatedData['descripcion'],
                'imagen_nombre' => $imagen_nombre,
                'imagen' => $imagen,
                'tipo_menu' => $validatedData['tipoMenu'],
                'platos_opciones' => $request->platos_opciones,
                'creado_por' => $creado_por,
                'evento_id' => $evento->id,
            ]);

            $invitacion_imagenes = [];
            foreach ($request->input('files') as $index => $file) {
                $nombre = $file['name'];
                $formato = $file['type'];
                $size = $file['size'];
                $imagen_base64 = substr($file['base64'], strpos($file['base64'], ",") + 1);

                $imagen = Imagen::create([
                    'nombre' => $nombre,
                    'formato' => $formato,
                    'size' => $size,
                    'imagen_base64' => $imagen_base64,
                    'creado_por' => $creado_por,
                ]);
                $invitacion_imagenes[] = [
                    'id' => (string) Str::uuid(),
                    'invitacion_id' => $invitacion->id,
                    'imagen_id' => $imagen->id,
                    'creado_por' => $creado_por,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('invitaciones_imagenes')->insert($invitacion_imagenes);

            $url_invitacion = url('/invitaciones/' . $invitacion->id);
            Mail::to($validatedData['email_org'])->send(new SendUrlInvitacion($url_invitacion));

            DB::commit();
            return response()->json([
                'message' => 'Invitacion agregada correctamente',
                'data' => $invitacion,
                'status' => 'success'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la invitacion: ' . $e->getMessage(),
            ], 400);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error de validación: ' . $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la invitacion: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function edit($id)
    {
        $invitacion = Invitacion::where('id', $id)
            ->with(['evento' => function ($query) {
                $query->select('id', 'nombre', 'email_organizador', 'telefono_organizador', 'fecha');
            }])
            ->with('imagenes')
            ->first();
        $invitacion->platos_opciones = json_decode($invitacion->platos_opciones);
        $title = 'Editar Invitación';
        return view('pages.invitacion.create', compact('invitacion', 'title'));
    }


    public function actualizarInvitacion(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required',
                'descripcion' => 'required',
                'tipoMenu' => 'required',
                'nombre_org' => 'required',
                'email_org' => 'required',
                'invitacion_id' => 'required | string'
            ]);
            $creado_por = auth()->user()->id;

            DB::beginTransaction();

            $invitacion = Invitacion::where('id', $request->invitacion_id)->first();
            $invitacion->update([
                'titulo' => $validatedData['titulo'],
                'texto' =>  $validatedData['descripcion'],
                'tipo_menu' => $validatedData['tipoMenu'],
                'platos_opciones' => $request->platos_opciones,
                'creado_por' => $creado_por,
            ]);

            $evento = Evento::where('id', $invitacion->evento_id)->first();
            $evento->update([
                'nombre' => $validatedData['nombre_org'],
                'email_organizador' => $validatedData['email_org'],
                'telefono_organizador' => $request->telefono_org,
                'fecha' => $request->fecha_evento,
                'creado_por' => $creado_por,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Invitacion actualizada correctamente',
                'data' => $invitacion,
                'status' => 'success'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la invitacion: ' . $e->getMessage(),
            ], 400);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error de validación: ' . $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la invitacion: ' . $th->getMessage(),
            ], 400);
        }
    }


    public function show(Invitacion $invitacion)
    {
        $page_title = $invitacion->titulo;
        $invitacion->platos_opciones = json_decode($invitacion->platos_opciones);

        return view('pages.invitacion.show', compact('invitacion', 'page_title'));
    }

    public function agregarDocumento(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'invitacion_id' => 'required | string'
            ]);
            $imagen = $request->input('documento.base64');
            $imagen = substr($imagen, strpos($imagen, ",") + 1);
            $sizeInMb = (strlen($imagen) * 3 / 4) / (1024 * 1024);
            if ($sizeInMb > 16) {
                return response()->json([
                    'message' => 'El tamaño de la imagen no puede ser mayor a 16MB',
                ], 400);
            }

            $creado_por = auth()->user()->id;

            $nombre = $request->input('documento.name');
            $formato = $request->input('documento.type');
            $size = $request->input('documento.size');
            $invitacion_imagenes = [];

            DB::beginTransaction();

            $imagen = Imagen::create([
                'nombre' => $nombre,
                'formato' => $formato,
                'size' => $size,
                'imagen_base64' => $imagen,
                'creado_por' => $creado_por,
            ]);
            $invitacion_imagenes[] = [
                'id' => (string) Str::uuid(),
                'invitacion_id' => $validatedData['invitacion_id'],
                'imagen_id' => $imagen->id,
                'creado_por' => $creado_por,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('invitaciones_imagenes')->insert($invitacion_imagenes);

            DB::commit();

            return response()->json([
                'message' => 'Documento agregado correctamente',
                'imagen' => $imagen,
                'status' => 'success'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([                
                'message' => 'Error al agregar el documento: ' . $e->getMessage(),
            ], 400);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error de validación: ' . $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al agregar el documento: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function eliminarDocumento(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'imagen_id' => 'required | string',
            'invitacion_id' => 'required | string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validate->errors(),
            ], 400);
        }

        try {
            $imagen_id = $request->imagen_id;
            $invitacion_id = $request->invitacion_id;

            $imagen = Imagen::where('id', $imagen_id)->first();
            $invitacion = Invitacion::where('id', $invitacion_id)->first();

            if (!$imagen) {
                return response()->json([
                    'message' => 'El documento no existe',
                ], 400);
            }

            if (!$invitacion) {
                return response()->json([
                    'message' => 'La invitacion no existe',
                ], 400);
            }

            $invitacion_imagen = DB::table('invitaciones_imagenes')
                ->where('invitacion_id', $invitacion_id)
                ->where('imagen_id', $imagen_id)
                ->first();

            if (!$invitacion_imagen) {
                return response()->json([
                    'message' => 'La documento no esta asociada a la invitacion',
                ], 400);
            }

            $invitacion_imagen = DB::table('invitaciones_imagenes')
                ->where('invitacion_id', $invitacion_id)
                ->where('imagen_id', $imagen_id)
                ->delete();

            $ImagenDelete = $imagen;

            $imagen->delete();

            return response()->json([
                'message' => 'Documento eliminado correctamente',
                'documento' => $ImagenDelete,
                'status' => 'success'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el documento: ' . $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al eliminar el documento: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function updateImagenMenu(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'invitacion_id' => 'required | string'
            ]);
            $imagen = $request->input('documento.base64');
            $imagen = substr($imagen, strpos($imagen, ",") + 1);
            $sizeInMb = (strlen($imagen) * 3 / 4) / (1024 * 1024);
            if ($sizeInMb > 16) {
                return response()->json([
                    'message' => 'El tamaño de la imagen no puede ser mayor a 16MB',
                ], 400);
            }

            $creado_por = auth()->user()->id;
            $nombre = $request->input('documento.name');            

            DB::beginTransaction();
            
            $invitacion = Invitacion::where('id', $request->invitacion_id)->first();
            $invitacion->update([
                'imagen_nombre' => $nombre,
                'imagen' => $imagen,                
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Imagen del menu actualizada correctamente',                
                'status' => 'success'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([                
                'message' => 'Error al actualizar la imagen del menu: ' . $e->getMessage(),
            ], 400);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error de validación: ' . $e->getMessage(),
            ], 400);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la imagen del menu: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function crearPlantilla(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tipoMenu' => 'required | string',
            'name' => 'required | string',
            'platos' => 'required | array',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validate->errors(),
            ], 400);
        }


        $platos = json_encode($request->platos);
        $tipoMenu = $request->tipoMenu;
        $name = $request->name;



        $plantilla = PlatillaMenu::create([
            'name' => $name,
            'description' => $request->description || 'Sin descripción',
            'tipo_menu' => $tipoMenu,
            'platos' => $platos,
        ]);

        return response()->json([
            'message' => 'Plantilla creada correctamente',
            'data' => $plantilla,
            'status' => 'success'
        ], 201);
    }

    public function getPlantillas(Request $request)
    {
        $plantillas = PlatillaMenu::all();

        foreach ($plantillas as $key => $plantilla) {
            $plantilla->platos = json_decode($plantilla->platos);
        }


        return response()->json([
            'message' => 'Plantillas obtenidas correctamente',
            'data' => $plantillas,
            'status' => 'success'
        ], 201);
    }

    public function getPlatos(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'evento_id' => 'required | string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validate->errors(),
            ], 400);
        }

        $platos_invitados = Invitado::where('evento_id', $request->evento_id)->get(['platos_elegidos', 'numero_personas']);

        $platos = [];

        foreach ($platos_invitados as $platos_elegidos_string) {
            $plato_decode = json_decode($platos_elegidos_string->platos_elegidos);
            $cantidadComensalesPInvitacion = $platos_elegidos_string->numero_personas;
            foreach ($plato_decode as $platos_del_invitado) {

                foreach ($platos_del_invitado as $plato) {
                    $data = [
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
                'plato' => $row[0]['plato'],
                'cantidad' => $row->sum('cantidad'),
            ];
        })->values();

        return response()->json($platos, 200);
    }

    public function getInvitadosByPlato(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'evento_id' => 'required | string',
            'plato' => 'required | string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validate->errors(),
            ], 400);
        }

        $invitados = Invitado::where('evento_id', $request->evento_id)->get();

        $invitados_plato = [];

        foreach ($invitados as $invitado) {
            $platos_elegidos = json_decode($invitado->platos_elegidos);
            foreach ($platos_elegidos as $platos_del_invitado) {
                foreach ($platos_del_invitado as $plato) {
                    if ($plato == $request->plato) {
                        $invitados_plato[] = $invitado;
                    }
                }
            }
        }

        return response()->json($invitados_plato, 200);
    }
}

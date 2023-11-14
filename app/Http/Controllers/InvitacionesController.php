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


class InvitacionesController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Invitaciones';
        return view('pages.invitacion.index', compact('page_title'));
    }

    public function agregarInvitacion(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required',
                'descripcion' => 'required',
                'tipoMenu' => 'required',                
                'files' => 'required|array|min:1',
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

            $evento_id = Evento::first()->id; // Cambiar luego por el evento seleccionado
            $creado_por = auth()->user()->id;           

            $imagen = $request->input('file_menu.base64');
            $imagen = substr($imagen, strpos($imagen, ",") + 1);

            DB::beginTransaction();
            $invitacion = Invitacion::create([
                'titulo' => $validatedData['titulo'],
                'texto' =>  $validatedData['descripcion'],
                'imagen' => $imagen,
                'tipo_menu' => $validatedData['tipoMenu'],
                'platos_opciones' => $request->platos_opciones,
                'creado_por' => $creado_por,
                'evento_id' => $evento_id,
            ]);

            $invitacion_imagenes = [];
            foreach ($request->input('files') as $index => $file) {
                $nombre = $file['name'];
                $formato = $file['type'];
                $size = $file['size'];
                // $imagen_base64 = substr($file['base64'], strpos($file['base64'], ",") + 1);

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
}

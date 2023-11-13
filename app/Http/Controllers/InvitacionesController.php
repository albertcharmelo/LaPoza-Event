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
                'files' => 'required',
                'files.*' => 'mimes:jpg,jpeg,png,bmp',
            ]);           

            $evento_id = Evento::first()->id; // Cambiar luego por el evento seleccionado
            
            $creado_por = auth()->user()->id;

            DB::beginTransaction();
            $invitacion = Invitacion::create([
                'titulo' => $validatedData['titulo'],
                'texto' =>  $validatedData['descripcion'],
                'tipo_menu' => $validatedData['tipoMenu'],
                'platos_opciones' => $request->platos_opciones,
                'creado_por' => $creado_por,
                'evento_id' => $evento_id,
            ]);

            $invitacion_imagenes = [];
            $imagenes = [];
            foreach ($request->file('files') as $file) {
                $nombre = $file->getClientOriginalName();
                $formato = $file->getClientOriginalExtension();
                $size = $file->getSize();                
                // $url = $file->store('images/invitaciones', 'public');
                $requestImagen = new Request();
                $requestImagen->merge(['imagen' => $file]);
                $imagen_base64 = UtilController::crearImagenBase64($requestImagen);
                $imagen = Imagen::create([
                    'nombre' => $nombre,
                    // 'url' => $url,
                    'formato' => $formato,
                    'size' => $size,
                    'imagen_base64' => $imagen_base64,
                    'creado_por' => $creado_por,
                ]);
                $imagenes[] = $imagen;

            }            
            $imagenes = DB::table('imagenes')->where('creado_por', $creado_por)->get();
            foreach ($imagenes as $imagen) {
                DB::table('invitaciones_imagenes')->insert([
                    'id' => (string) Str::uuid(),
                    'invitacion_id' => $invitacion->id,
                    'imagen_id' => $imagen->id,
                    'creado_por' => $creado_por,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);            
            }          
           
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

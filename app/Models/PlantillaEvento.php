<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaEvento extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = [
        'id',
        'titulo',
        'texto',
        'imagen',
        'imagen_nombre',
        'tipo_menu',
        'platos_opciones',
        'datos_requeridos',
    ];
    protected $table = 'plantillas_eventos';
}

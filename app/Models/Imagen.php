<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'imagenes';
    protected $fillable = [
        'id',
        'nombre',        
        'formato',
        'size',
        'imagen_base64',
        'creado_por',
        'created_at',
        'updated_at',
    ];


    public function invitaciones()
    {
        return $this->belongsToMany(Invitacion::class, 'invitaciones_imagenes');
    }
}

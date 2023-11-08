<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOpcion extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'menu_opciones';
    protected $fillable = [
        'id',
        'invitacion_id',
        'evento_id',
        'invitado_id',
        'opcion',
        'created_at',
        'updated_at',
    ];
}

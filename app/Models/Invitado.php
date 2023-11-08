<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'invitados';
    protected $fillable = [
        'id',
        'invitacion_id',
        'evento_id',
        'nombre',
        'telefono',
        'email',
        'nif',
        'numero_personas',
        'observaciones',
        'asistencia_confirmada',
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener la invitacion asociada al invitado
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invitacion()
    {
        return $this->hasOne(Invitacion::class, 'id', 'invitacion_id');
    }

    /**
     * Obtener el evento asociado al invitado
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function evento()
    {
        return $this->hasOne(Evento::class, 'id', 'evento_id');
    }


    /**
     * Obtener las opciones de menu asociadas al invitado
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function menuOpciones()

    {
        return $this->hasMany(MenuOpcion::class, 'invitado_id', 'id');
    }
}

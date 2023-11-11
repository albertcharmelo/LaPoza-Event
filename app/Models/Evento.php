<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'eventos';
    protected $with = ['invitados', 'invitacion'];
    protected $fillable = [
        'id',
        'nombre',
        'email_organizador',
        'telefono_organizador',
        'numero_invitados',
        'ingreso_bruto',
        'fecha',
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener las invitaciones asociada al evento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invitacion()
    {
        return $this->hasOne(Invitacion::class, 'evento_id', 'id');
    }

    /**
     * Obtener los invitados asociados al evento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'evento_id', 'id');
    }

    /**
     * Devuelve una relación de todos los invitados confirmados para este evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitadosConfirmados()
    {
        return $this->hasMany(Invitado::class, 'evento_id', 'id')->where('asistencia_confirmada', true);
    }

    /**
     * Devuelve una relación de todos los invitados ausentes en este evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitadosAusentes()
    {
        return $this->hasMany(Invitado::class, 'evento_id', 'id')->where('asistencia_confirmada', false);
    }


    /**
     * Obtener las opciones de menu asociadas al evento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function menuOpciones()
    {
        return $this->hasMany(MenuOpcion::class, 'evento_id', 'id');
    }
}

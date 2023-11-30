<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'invitaciones';

    protected $fillable = [
        'id',
        'titulo',
        'texto',
        'imagen',
        'imagen_nombre',
        'tipo_menu',
        'platos_opciones',
        'evento_id',
        'creado_por',
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener el evento asociado a la invitacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function evento()
    {
        return $this->hasOne(Evento::class, 'id', 'evento_id');
    }

    /**
     * Obtener los invitados asociados a la invitacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'invitacion_id', 'id');
    }

    /**
     * Obtener los codigos qr asociados a la invitacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codigosQr()
    {
        return $this->hasMany(CodigoQr::class, 'invitacion_id', 'id');
    }

    /**
     * Obtener las opciones de menu asociadas a la invitacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuOpciones()
    {
        return $this->hasMany(MenuOpcion::class, 'invitacion_id', 'id');
    }

    /**
     * Obtener el creador de la invitacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function creador()
    {
        return $this->hasOne(User::class, 'id', 'creado_por');
    }

    /**
     * Obtener las imagenes asociadas a la invitacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function imagenes()
    {
        return $this->belongsToMany(Imagen::class, 'invitaciones_imagenes', 'invitacion_id', 'imagen_id');
    }
}

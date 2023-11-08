<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoQr extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'codigo_qr';
    protected $fillable = [
        'id',
        'invitacion_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener la invitacion asociada al codigo qr
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invitacion()
    {
        return $this->hasOne(Invitacion::class, 'id', 'invitacion_id');
    }
}

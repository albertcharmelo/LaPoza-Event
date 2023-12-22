<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'nombre',
    ];
    protected $table = 'restaurantes';


    /**
     * Obtener los eventos asociados al restaurante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'restaurante_id', 'id');
    }
}

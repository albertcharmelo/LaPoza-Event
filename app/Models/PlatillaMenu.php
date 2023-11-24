<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatillaMenu extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = [
        'name',
        'tipo_menu',
        'platos',
    ];
    protected $table = 'plantillas_menus';
}

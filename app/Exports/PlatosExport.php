<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class PlatosExport implements FromArray
{

    protected $platos;


    public function __construct(array $platos)
    {
        $this->platos = $platos;
    }


    /**
     * Retorna un array con los platos exportados.
     *
     * @return array
     */
    public function array(): array
    {
        return $this->platos;
    }
}

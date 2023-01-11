<?php

namespace App\Imports;

use App\Models\Proyecto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ProyectosImport implements ToModel
{
    use Importable;
   
    public function model(array $row)
    {
        return new Proyecto([
            'nombre' => $row[0],
        ]);
    }
}

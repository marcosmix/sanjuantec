<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class EstudiantesImport implements ToModel
{
    use Importable;
    
    public function model(array $row)
    {
        return new Estudiante([
            'nombre' => $row[0],
            'apellido' => $row[1],
            'dni' => $row[2],
            'celular' => $row[3],
            'email' => $row[4],
        ]);
    }
}

<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class CursatecImport implements ToModel
{  use Importable;
    public function model(array $row)
    {
        return new Contacto([
            'user'=>$row[0],
            'pass'=>$row[1],
            'email'=>$row[2],
            'nombre'=>$row[3],
            'apellido'=>$row[4],
            'curso'=>$row[5],
        ]);
    }
}

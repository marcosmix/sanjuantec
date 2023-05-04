<?php

namespace App\Imports;

use App\Models\Contacto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
class CuentasCursatec implements ToModel
{
  
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

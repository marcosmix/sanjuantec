<?php

namespace App\Imports;

use App\Models\Contacto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class ContactosImport implements ToModel
{
   
    public function model(array $row)
    {
        return new Contacto([
                'nombre'=>$row[0],
                'apellido'=>$row[1],
                'dni' => $row[2],
                'celular' => $row[3],
                'email'=>$row[4],
        ]);
    }
}

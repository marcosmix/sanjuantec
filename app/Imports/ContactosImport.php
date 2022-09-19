<?php

namespace App\Imports;

use App\Models\Contacto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class ContactosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contacto([
                'nombre'=>$row[0],
                'apellido'=>$row[1],
                'celular' => $row[2],
                'email'=>$row[3],
                'curso' => $row[4],
        ]);
    }
}

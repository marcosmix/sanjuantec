<?php

namespace App\Imports;

use App\Models\CertificadoEspecial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CertificadosEspeciales implements ToModel
{
   public function model(array $row){
        return new  CertificadoEspecial([
                'nombre_apellido'=>$row[0],
                'dni'=>$row[1],
                'email'=>$row[2],
                'nombre_certificacion'=>$row[3],
                'duracion' => $row[4],
                'texto' => $row[5],
                'duracion' => $row[6],
            ]
        );
    }
}

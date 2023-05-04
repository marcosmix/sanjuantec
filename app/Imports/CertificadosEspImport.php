<?php

namespace App\Imports;

use App\Models\CertificadoEspecial;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
class CertificadosEspImport implements ToModel
{
    use Importable;
    public function model(array $row)
    {
        return new CertificadoEspecial([
            'nombre_apellido' => $row[0],
            'dni' => $row[1],
            'email' => $row[2],
            'nombre_certificacion' => $row[3],
            'duracion' => $row[4],
            'texto' => $row[5],
            'firmas' => $row[6],
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\gpdf;
use App\Helpers\rutas;

class Certificado extends Model
{
    use HasFactory;

    public function generarCertificadosPorCurso ($curso, $listado)
    {
        // dd($curso, $listado);
        /*
        foreach ($listado[0] as $nombre) {
            $this->procesarCertificadosJam($nombre[0]);
        }*/

        return true;
    }
}

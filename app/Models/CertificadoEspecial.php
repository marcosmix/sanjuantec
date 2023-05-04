<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificadoEspecial extends Model
{
    protected $guarded = [];
    use HasFactory;

    static public function normalizarDatos($array,$static){
        return [
            'nombre'              => $array[0],
            'dni'                 => (string)($array[1]),
            'mail'                => $array[2],
            'certificacion'       => $array[3],
            'duracion'            => $array[4],
            'texto'               => $array[5],
            'firmas'              => $array[6],
            'bloque_organizacion' => $static['bloque_organizacion'],
            'fecha'               => $static['fecha'],
        ];
    }
}

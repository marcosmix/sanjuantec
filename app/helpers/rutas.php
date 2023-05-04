<?php
namespace App\helpers;

trait rutas{
    protected $raiz='certificados\\';

    public function GenerarRutaPDF($curso, $estudiante){
        return $this->raiz. $curso['nombre'] . "\\" . strval($estudiante['dni']) . ".pdf";
    }

    public function GenerarRutaPDFv2($carpeta, $pdf){
        return $this->raiz . $carpeta . "\\" .$pdf. ".pdf";
    }


    public function RutaCarpetaStoragePublic($curso, $estudiante){
        return 'storage'."\\".$this->raiz . $curso['nombre'].'\\' . strval($estudiante['dni']) . ".pdf";
    }

    public function RutaCarpetaStorage($curso)
    {
        return $this->raiz . $curso['nombre'] . '\\';
    }

    public function NombreArchivoPDF($estudiante){
        return strval($estudiante['dni']).".pdf";
    }
}

?>
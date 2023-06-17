<?php
namespace App\Helpers;

trait rutas
{
    protected $raiz='certificados'.DIRECTORY_SEPARATOR;

    public function GenerarRutaPDF ($curso, $estudiante)
    {
        return $this->raiz. $curso['nombre'].DIRECTORY_SEPARATOR. strval($estudiante['dni']) . ".pdf";
    }

    public function GenerarRutaPDFv2 ($carpeta, $pdf)
    {
        return $this->raiz.$carpeta .DIRECTORY_SEPARATOR.$pdf. ".pdf";
    }

    public function RutaCarpeta ($curso)
    {
        return $this->raiz.$curso['nombre'].DIRECTORY_SEPARATOR;
    }

    public function RutaCarpetaStoragePublic ($curso, $estudiante)
    {
        return 'storage'.DIRECTORY_SEPARATOR.$this->raiz . $curso['nombre'].DIRECTORY_SEPARATOR. strval($estudiante['dni']).".pdf";
    }

    public function RutaCarpetaStorage ($curso)
    {
        return 'storage'.DIRECTORY_SEPARATOR.$this->raiz . $curso['nombre'].DIRECTORY_SEPARATOR;
    }

    public function NombreArchivoPDF ($estudiante)
    {
        return strval($estudiante['dni']).".pdf";
    }
}

?>

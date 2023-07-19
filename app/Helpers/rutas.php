<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

trait rutas
{
    protected $raiz='certificados'.DIRECTORY_SEPARATOR;

    public function GenerarRutaPDF ($curso, $documento)
    {
        return $this->raiz. $curso['nombre'].DIRECTORY_SEPARATOR. $documento . ".pdf";
    }

    public function GenerarRutaPDFv2 ($carpeta, $pdf)
    {
        return $this->raiz.$carpeta .DIRECTORY_SEPARATOR.$pdf. ".pdf";
    }

    public function RutaCarpeta ($curso)
    {
        return $this->raiz.$curso['nombre'].DIRECTORY_SEPARATOR;
    }

    public function RutaCarpetaYArchivo ($curso, $estudiante)
    {
        return $this->raiz.$curso['nombre'].DIRECTORY_SEPARATOR.$this->NombreArchivoPDF($estudiante);
    }

    public function RutaCarpetaStoragePublic ($curso, $estudiante)
    {
        $nombreArchivo = strval($estudiante['documento']) . '.pdf';
        $directorio = Storage::disk('public')->path($this->raiz) . $curso['nombre'] . DIRECTORY_SEPARATOR . $nombreArchivo;
        return $directorio;
    }

    public function RutaCarpetaStorage ($curso)
    {
        $directorio = Storage::disk('public')->path($this->raiz) . $curso['nombre'] . DIRECTORY_SEPARATOR;
        return $directorio;
    }

    public function NombreArchivoPDF ($estudiante)
    {
        return strval($estudiante['documento']).".pdf";
    }
}

?>

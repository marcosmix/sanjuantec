<?php

namespace App\Http\Controllers;

use App\Helpers\rutas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class PdfController extends Controller
{
    use rutas;

    public function mostrarPdf ($documento, $nombreCurso)
    {
        try {
            $directorio = $this->RutaCarpetaStoragePublic(['nombre' => $nombreCurso], ['documento' => $documento]);
            return response()->file($directorio);
        } catch (FileNotFoundException $e) {
            return response()->json(['error' => 'Certificado no encontrado.'], 404);
        }
    /**
     * Muestra un archivo PDF de certificado en el navegador.
     * @author Leandro Brizuela
     * @param string $documento El documento del estudiante, que a su vez corresponde al nombre del archivo PDF a mostrar.
     * @param string $nombreCurso El nombre del curso asociado al certificado, que a su vez corresponde al directorio donde
     * se encuentra el archivo PDF.
     * @return \Illuminate\Http\Response La respuesta HTTP con el archivo PDF o un mensaje de error si no se encuentra.
     */
    }
}

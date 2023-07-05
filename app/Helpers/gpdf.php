<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

trait gpdf
{
    public function generarPDF ($datos, $vista, $horizontal = false, $url)
    {
        // Inicializar Dompdf con opciones.
        $options = new Options();
        $options->set(['isRemoteEnabled' => true]);
        $dompdf = new Dompdf($options);

        // Compartir datos junto a la vista.
        view()->share($vista, ['datos' => $datos]);

        // Cargar la vista hacia Dompdf.
        $dompdf->loadHtml(view($vista, ['datos' => $datos]));

        // Determinar la orientación a landscape si $horizontal es verdadero.
        if ($horizontal) {
            $dompdf->setPaper('A4', 'landscape');
        }

        // Renderizar pdf.
        $dompdf->render();

        // Obtener el PDF resultante.
        $output = $dompdf->output();

        // Crear el directorio si no existe aún.
        $directorio = public_path($url);
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }

        // Guardar el archivo PDF en la ruta especificada.
        $locacionArchivo = $directorio . $datos['estudiante']['documento'] . '.pdf';
        file_put_contents($locacionArchivo, $output);

        // Devolver el archivo PDF como una respuesta descargable.
        return response()->download($locacionArchivo);
    /**
     * Método requerido para la conformación y guardado de certificados PDF.
     * @Autores: Marcos Caballero, Leandro Brizuela.
     * Se ha implementado una nueva funcionalidad para crear directorios en caso de que no existan.
     *
     * @param array $datos Matriz con los datos requeridos para la conformación del PDF.
     * @param string $vista Nombre de la vista Blade. Ejemplo: "certificados.modelo1".
     * @param bool $horizontal Valor lógico que determina la orientación del PDF (horizontal o vertical).
     *                        True para horizontal, false para vertical.
     * @param string $url Directorio desde la raíz de la aplicación donde se almacenará el archivo PDF.
     *
     * @return object Archivo resultante como una respuesta descargable.
     */
    }



    // public function generarCertificadoJam($nombre_proyecto)
    // {

    //     //inicio optimizar esta parte
    //     $options = new Options();
    //     $options->set(['isRemoteEnabled' => true]);

    //     $dompdf = new Dompdf($options);

    //     view()->share($vista, ['datos' => $datos]);
    //     $dompdf->loadhtml(view($vista, ['datos' => $datos]));


    //     if ($horizontal)
    //         $dompdf->setPaper('A4', 'landscape');

    //     $dompdf->render();
    //     $output = $dompdf->output();
    //     //fin optimizar esta parte

    //     view()->share($vista, ['datos' => $datos]);
    //     $pdf = Pdf::loadView($vista, ['datos' => $datos]);
    //     $pdf->setPaper('A4', 'landscape');
    //     $pdf->render();
    //     $output = $pdf->output();

    //     Storage::disk('public')->put($url, $output);
    //     //  $dompdf->stream($url, array('Attachment' => false));
    //     //file_put_contents($url, $output);

    //     return $pdf->download('$url');
    // }
}
?>

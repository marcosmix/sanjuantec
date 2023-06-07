<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

trait gpdf{

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

        // Compartir nuevamente los datos con la vista (para una librería PDF diferente).
        view()->share($vista, ['datos' => $datos]);

        // Generar un PDF utilizando la clase Pdf (se asume que ha sido importada previamente).
        $pdf = Pdf::loadView($vista, ['datos' => $datos]);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $output = $pdf->output();

        // Guardar el archivo PDF en la ruta especificada, utilizando el Storage de Laravel.
        Storage::disk('public')->put($url, $output);

        // Devolver el archivo PDF como una respuesta descargable.
        return $pdf->download('$url');
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

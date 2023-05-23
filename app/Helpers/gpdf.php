<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

trait gpdf{
    public function generarPDF($datos,$vista,$horizontal=false,$url){
        //inicio optimizar esta parte
        $options = new Options();
        $options->set(['isRemoteEnabled'=> true]);

        $dompdf = new Dompdf($options);

        view()->share($vista, ['datos' => $datos]);
        $dompdf->loadhtml(view($vista, ['datos' => $datos]));


        if($horizontal)
         $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();
        $output = $dompdf->output();
 //fin optimizar esta parte

        view()->share($vista, ['datos' => $datos]);
        $pdf = Pdf::loadView($vista, ['datos' => $datos]);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $output = $pdf->output();

       Storage::disk('public')->put($url, $output);
        //  $dompdf->stream($url, array('Attachment' => false));
        //file_put_contents($url, $output);

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

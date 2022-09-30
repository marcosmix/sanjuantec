<?php

namespace App\helpers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

trait gpdf{
    public function generarPDF($datos,$vista,$horizontal=false,$url){
        $options = new Options();
        $options->set(['isRemoteEnabled'=> true, 'isHtml5ParserEnabled' => true]);

        $dompdf = new Dompdf($options);

        view()->share($vista, ['datos' => $datos]);
        $dompdf->loadhtml(view($vista, ['datos' => $datos]));
    
        
        if($horizontal)
         $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();
        $output = $dompdf->output();


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
}

?>
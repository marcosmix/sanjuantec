<?php

namespace App\helpers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

trait pdf{
    public function generarPDF($datos,$modelo,$horizontal=false,$url){
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        view()->share('certificados.modelo1', ['datos' => $datos]);
        $dompdf->loadhtml(view('certificados.modelo1', ['datos' => $datos]));
    
        
        if($horizontal)
         $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();
        $output = $dompdf->output();
        //$dompdf->render($url,$output);

       Storage::disk('public')->put($url, $output);
        //  $dompdf->stream($url, array('Attachment' => false));
        //file_put_contents($url, $output);

        return;
    }
}

?>
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\helpers\rutas;

class CertificadosMail extends Mailable
{
    use Queueable, SerializesModels,rutas;

    public $estudiante,$curso,$mensaje;
  
    public function __construct($estudiante,$curso, $mensaje='Test '){
        $this->estudiante= $estudiante;
        $this->curso = $curso;
        $this->mensaje=$mensaje;
    }

    

    public function build(){
        
        
        return $this->from('sanjuantec@sjtec.com','San Juan Tec')->view('mail.certificado')
                ->subject('San Juan Tec')
                ->replyTo('sanjuantec@sjtec.com','SAN JUAN TEC')
                ->attach(public_path($this->RutaCarpetaStoragePublic($this->curso,$this->estudiante)),[
                    'as'=> $this->NombreArchivoPDF($this->estudiante),
                    'mime'=> 'application/pdf'
                ]);

                
    }
}

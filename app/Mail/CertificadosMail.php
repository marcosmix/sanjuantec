<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\helpers\rutas;

class CertificadosMail extends Mailable
{
    use Queueable, SerializesModels, rutas;

    public $estudiante, $curso, $mensaje;

    public function __construct($estudiante, $curso, $mensaje = 'Test')
    {
        $this->estudiante = $estudiante;
        $this->curso = $curso;
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        $curso = $this->curso['nombre'];
        $dniEstudiante = $this->estudiante->dni;
        $estudianteArray = $this->estudiante->toArray(); // Esta conversión de objeto a matriz es necesaria
        // para la generación de la rutaArchivoAdjunto.

        $rutaArchivoAdjunto = public_path($this->GenerarRutaPDF($this->curso, $estudianteArray));

        // Verificación de archivo de certificado .pdf
        if (!file_exists($rutaArchivoAdjunto)) {
            dd("El archivo adjuntable no ha sido encontrado en el directorio: " . $rutaArchivoAdjunto);
        }

        // Envío de email
        return $this->from('sanjuantec@sjtec.com', 'San Juan Tec')
            ->view('mail.certificado')
            ->subject('San Juan Tec')
            ->replyTo('sanjuantec@sjtec.com', 'SAN JUAN TEC')
            ->attach($rutaArchivoAdjunto, [
                'as' => $this->NombreArchivoPDF($this->estudiante),
                'mime' => 'application/pdf'
            ]);
    }
}

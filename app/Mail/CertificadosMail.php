<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Helpers\rutas;

class CertificadosMail extends Mailable
{
    /**
     * Descripción: CertificadosMail que realiza el envío de emails utilizando los datos del curso y del alumno.
     *
     * @param array $curso Una matriz que contiene información del curso.
     *        - 'id' (int): El identificador único del curso.
     *        - 'nombre' (string): El nombre del curso.
     * @param Alumno $estudiante Un objeto Alumno que contiene información del estudiante.
     *        - nombre (string): El nombre del alumno.
     *        - apellido (string): El apellido del alumno.
     *        - documento (string): El número de documento del alumno.
     *        - email (string): La dirección de correo electrónico del alumno.
     * @param string $mensaje El mensaje que se utilizará en el email.
     * @return bool true
     * @author Leandro Brizuela
     */

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
        $matrizCurso['nombre'] = $this->curso['nombre'];
        $matrizEstudiante['documento'] = $this->estudiante->documento;

        $rutaArchivoAdjunto = $this->RutaCarpetaStoragePublic($matrizCurso, $matrizEstudiante);

        // Verificación de archivo de certificado .pdf.
        if (!file_exists($rutaArchivoAdjunto)) {
            dd("El archivo adjuntable no ha sido encontrado en el directorio " . $rutaArchivoAdjunto);
        }

        $rutaStorageRelativa = $this->RutaCarpetaYArchivo($matrizCurso, $matrizEstudiante);

        // Envío de email.
        $this->from('sanjuantec@sjtec.com', 'San Juan Tec')
            ->view('mail.certificado')
            ->subject('San Juan Tec')
            ->replyTo('sanjuantec@sjtec.com', 'SAN JUAN TEC')
            ->attachFromStorageDisk('public', $rutaStorageRelativa, $this->nombreArchivoPdfEmail($matrizCurso['nombre'], $this->estudiante), [
                'mime' => 'application/pdf'
            ]);

        return true;
    }

    public function nombreArchivoPdfEmail ($curso, $estudiante)
    {
        $nombreArchivoPDF = "Certificado del curso de {$curso} - {$estudiante->nombre} {$estudiante->apellido}";
        return $nombreArchivoPDF;
    }
}

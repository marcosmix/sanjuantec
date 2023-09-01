<?php

namespace App\Jobs;

use App\container\MensajesContainer;
use App\Helpers\MailTec;
use App\Models\Alumno;
use App\Models\MailEnviado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarEmailAjaxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $datos;
    /**
     * @name Clase EnviarEmailAjaxJob
     * @author Leandro Brizuela
     * Descripción: realiza el envío de emails en segundo plano, utilizando los datos del curso y del alumno.
     *
     * @var array $datos Una matriz que contiene información de un conjunto de datos para envío de correos.
     *
     * - [0] (array): Matriz que representa un conjunto de datos para envío de correo.
     *   - 'idCurso' (int): El identificador único del curso.
     *   - 'nombreCurso' (string): El nombre del curso.
     *   - 'nombreAlumno' (string): El nombre del alumno.
     *   - 'apellidoAlumno' (string): El apellido del alumno.
     *   - 'documentoAlumno' (string): El número de documento del alumno.
     *   - 'emailAlumno' (string): La dirección de correo electrónico del alumno.
     */

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $alumno = new Alumno();
        $mailEnviado = new MailEnviado();
        $mensaje = MensajesContainer::difusionMarketing();
        $tamañoLote = 5; // Determina el número máximo de emails por lote.
        $lotes = array_chunk($this->datos, $tamañoLote);

        foreach ($lotes as $lote) {
            foreach ($lote as $certificado) {
                $curso = ['id' => $certificado['idCurso'], 'nombre' => $certificado['nombreCurso']];
                $alumno->nombre = $certificado['nombreAlumno'];
                $alumno->apellido = $certificado['apellidoAlumno'];
                $alumno->documento = $certificado['documentoAlumno'];
                $alumno->email = $certificado['emailAlumno'];

                MailTec::EnviarMailCertificados(
                    $alumno,
                    $curso,
                    $mensaje
                );
                $mailEnviado->guardarEmailEnviado($alumno->documento, $curso['id']);
            }
        }
    /**
     * Proceso en segundo plano para enviar correos electrónicos con certificados.
     *
     * Este método maneja el proceso en segundo plano para enviar correos electrónicos con certificados a múltiples destinatarios.
     * Utiliza un tamaño de lote para dividir los datos en grupos más pequeños y luego itera a través de cada lote para enviar
     * correos electrónicos individualmente. Cada correo electrónico contiene información del alumno y del curso, así como un mensaje predefinido.
     */
    }
}

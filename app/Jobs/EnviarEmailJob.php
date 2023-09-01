<?php

namespace App\Jobs;

use App\Helpers\MailTec;
use App\Models\Certificado;
use App\Models\MailEnviado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarEmailJob implements ShouldQueue
{
    /**
     * Descripción: EnviarEmailJob que realiza el envío de emails en segundo plano,
     * utilizando los datos del curso y del alumno.
     *
     * @param array $curso Una matriz que contiene información del curso.
     *        - 'id' (int): El identificador único del curso.
     *        - 'nombre' (string): El nombre del curso.
     * @param Alumno $listado Una matriz de objetos Alumno que contienen información de estudiantes.
     *        - nombre (string): El nombre del alumno.
     *        - apellido (string): El apellido del alumno.
     *        - documento (string): El número de documento del alumno.
     *        - email (string): La dirección de correo electrónico del alumno.
     * @param string $mensaje El mensaje que se utilizará en el email.
     * @return bool true
     * @author Leandro Brizuela
     */

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $listado;
    protected $curso;
    protected $mensaje;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct ($curso, $mensaje, $listado)
    {
        $this->listado = $listado;
        $this->curso = $curso;
        $this->mensaje = $mensaje;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cursoDatos = $this->curso;
        $listadoDatos = $this->listado;
        $mensajeDatos = $this->mensaje;
        $mailEnviado = new MailEnviado();
        $tamañoLote = 5; // Determina el número máximo de emails por lote.
        $lotes = array_chunk($listadoDatos, $tamañoLote);

        foreach ($lotes as $lote) {
            foreach ($lote as $datos) {
                MailTec::EnviarMailCertificados(
                    $datos,
                    $cursoDatos,
                    $mensajeDatos
                );
                $mailEnviado->guardarEmailEnviado($datos->documento, $cursoDatos['id']);
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

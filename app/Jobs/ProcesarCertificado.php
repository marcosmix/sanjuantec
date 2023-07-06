<?php

namespace App\Jobs;

use App\Models\Alumno;
use App\Models\Certificado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcesarCertificado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $curso;
    public $listado;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct ($curso, $listado)
    {
        $this->curso = $curso;
        $this->listado = $listado;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tamañoLote = 20; // Determina el número máximo de certificados por lote.
        $cursoDatos = $this->curso;
        $listadoDatos = $this->listado;
        $lotes = array_chunk($listadoDatos, $tamañoLote);
        $certificado = new Certificado();
        $alumnoModel = new Alumno();

        foreach ($lotes as $lote) {
            foreach ($lote as $estudiante) {
                // Generar certificado en formato pdf.
                $rutaGenerada = $certificado->generarCertificadosPorCurso($cursoDatos, $estudiante);
                $idAlumno = $alumnoModel->obtenerIdAlumnoPorDocumento($estudiante->documento);

                if (($rutaGenerada) && ($idAlumno)) {
                    // Insertar o actualizar datos de un certificado en la base de datos.
                    $certificado->crearOActualizarCertificado($idAlumno, $rutaGenerada);
                }
            }
        }
    }
}

<?php

namespace App\Jobs;

use App\Helpers\gpdf;
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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, gpdf;

    public $curso;
    public $listado;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($curso, $listado)
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
        $alumnoModel = new Alumno();
        $certificadoModel = new Certificado();

        // Obtener IDs de todos los alumnos.
        $documentos = array_column($listadoDatos, 'documento');
        $idAlumnos = $alumnoModel->obtenerIdsAlumnosPorDocumentos($documentos);

        foreach ($lotes as $lote) :
            // 'Limpiar' matriz para el lote siguiente.
            $certificados = [];

            foreach ($lote as $estudiante) :

                // Generar certificado en formato pdf.
                $directorioCompleto = $this->generarCertificadoCursoAlumno($cursoDatos, $estudiante);

                $idAlumno = $idAlumnos[$estudiante->documento] ?? null;

                if ($directorioCompleto && $idAlumno) {
                    $certificados[] = [
                        'idAlumno' => $idAlumno,
                        'directorioCompleto' => $directorioCompleto
                    ];
                }
            endforeach;

            // Insertar o actualizar datos de certificados en la base de datos.
            $certificadoModel->crearOActualizarCertificados($certificados, $cursoDatos['id']);

        endforeach;
    }
}

<?php

namespace App\Jobs;

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

        foreach ($lotes as $lote) {
            $certificados = [];

            foreach ($lote as $estudiante) {
                $certificadoGenerado = $certificado->generarCertificadosPorCurso($cursoDatos, $estudiante);
                $certificados[] = $certificadoGenerado;
            }

            // TODO Procesar el lote (ej., guardar los certificados en la base de datos)
            // Ejemplo:
            // self::insert($certificados);
        }
    }
}

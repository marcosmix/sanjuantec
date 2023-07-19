<?php

namespace App\Jobs;

use App\Helpers\MailTec;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnviarEmailJob implements ShouldQueue
{
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
        $tamañoLote = 5; // Determina el número máximo de emails por lote.
        $lotes = array_chunk($listadoDatos, $tamañoLote);

        foreach ($lotes as $lote) {
            foreach ($lote as $datos) {
                MailTec::EnviarMailCertificados(
                    $datos,
                    $cursoDatos,
                    $mensajeDatos
                );
            }
        }
    }
}

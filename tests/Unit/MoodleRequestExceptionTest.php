<?php

namespace Tests\Unit;

use App\Exceptions\MoodleRequestException;
use Tests\TestCase;
use stdClass;

class MoodleRequestExceptionTest extends TestCase
{
    public function testMoodleRequestException()
    {
        $this->expectException(MoodleRequestException::class);
        $this->expectExceptionMessage("Consulta Moodle ha fallado con el código de estado: 404");

        // Desencadena la excepción llamando al método que lo lanza.
        $this->simulateMoodleRequestFailure();
    }

    private function simulateMoodleRequestFailure()
    {
        // Simula una consulta a Moodle fallida.
        $respuesta = new stdClass();
        $respuesta->successful = false;
        $respuesta->status = 404;

        if (!$respuesta->successful) {
            $codigoEstado = $respuesta->status;
            throw new MoodleRequestException("Consulta Moodle ha fallado con el código de estado: $codigoEstado");
        }
    }
}

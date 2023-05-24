<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use App\Exceptions\MoodleRequestException;

class CursaTec
{
    private $moodleToken;

    public function __construct()
    {
        $this->moodleToken = env('MOODLE_TOKEN');
    }

    public function obtenerCursos ()
    {
        $endpoint = config('moodle.endpoint');
        // Conformar matriz de consulta.
        $consulta = [
            'wstoken' => $this->moodleToken,
            'wsfunction' => 'core_course_get_courses',
            'moodlewsrestformat' => 'json'
        ];
        // Conformar consulta de tipo GET con Guzzle.
        $respuesta = Http::get($endpoint, $consulta);

        if ($respuesta->successful()) {
            $datosCursos = $respuesta->json();
            return $datosCursos;
        } else {
            $codigoEstado = $respuesta->status();
            throw new MoodleRequestException("Consulta Moodle ha fallado con el código de estado: $codigoEstado");
        }
    /**
     * Este método obtiene todos los cursos y sus datos en la plataforma Moodle de Cursatec.
     * Para realizar la petición GET se recurre a Guzzle como cliente HTTP de Laravel.
     * @author Leandro Brizuela
     * @date 23 de mayo de 2023.
     * @return array $datosCursos
     */
    }
}

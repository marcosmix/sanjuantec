<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

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
            var_dump($datosCursos);
        } else {
            $codigoEstado = $respuesta->status();
        }
    /**
     * Este método obtiene todos los cursos en la plataforma Moodle de Cursatec.
     * TODO Se recurrió provisoriamente en un var_dump(). Posteriormente, se devolverán los datos para ser
     * utilizados donde sea requerido.
     * @author Leandro Brizuela
     * @date 23 de mayo de 2023.
     */
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\gpdf;
use App\Helpers\rutas;

class Certificado extends Model
{
    use HasFactory, gpdf, rutas;

    public function generarCertificadosPorCurso ($curso, // Array
                                                 $estudiante // Object
                                                 )
    {
        $datos = [
            'curso' => [
                'nombre' => $curso['nombre'],
                'texto' => $curso['texto'],
                'duracion' => $curso['duracion'],
                'bloque' => $curso['bloque'],
                'fecha' => $curso['fecha']
            ],
            'estudiante' => [
                'nombre' => $estudiante->nombre,
                'apellido' => $estudiante->apellido,
                'dni' => $estudiante->dni
            ]
        ];

        $rutaGenerada = $this->RutaCarpeta($curso);

        $descargable = $this->generarPDF(
            $datos, // Datos para conformar el certificado.
            "certificados.modelo1", // Vista blade del certificado.
            true, // Determina si la hoja está orientada horizontalmente (True si será horizontal).
            $rutaGenerada // Directorio de ubicación y nombre del archivo pdf.
        );

        return true;
    /**
     * Este método conforma la estructura de datos necesaria para generar un certificado en formato PDF.
     * TODO BEGIN
     * La vista Blade utilizada como plantilla general es certificados.modelo1. Es posible que una nueva vista
     * sea requerida para la generación de nuevos certificados END
     * @name generarCertificadosPorCurso()
     * @author Leandro Brizuela.
     * @param array $curso Matriz con datos de un curso.
     * @param object $estudiante Objeto de datos con los datos de cada alumno/destinatario.
     * @return bool True si no ocurrió una interrupción inesperada.
     */
    }
}

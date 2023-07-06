<?php

namespace App\Models;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Helpers\gpdf;
use App\Helpers\rutas;

class Certificado extends Model
{
    use HasFactory, gpdf, rutas;

    protected $fillable = [
        'id',
        'id_alumno',
        'directorio'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    /**
     * Este método establece la relación "belongsTo" entre el modelo actual y el modelo Alumno.
     * Indica que un objeto de este modelo pertenece a una instancia de Alumno relacionada a través
     * del campo 'id_alumno'.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo La relación "belongsTo" entre el
     * modelo actual y el modelo Alumno.
     */
    }

    public function crearOActualizarCertificado ($alumnoId, $directorio)
    {
        $id = Str::random(5);

        $accionFinal = "N/A";

        if (empty($alumnoId)) {
            return false;
        }

        $certificado = [
            'id' => $id,
            'id_alumno' => $alumnoId,
            'directorio' => $directorio
        ];

        try {
            // Intentar encontrar el registro por 'id_alumno'. Actualizar registro.
            $certificadoExistente = self::where('id_alumno', $alumnoId)->firstOrFail();
            $certificadoExistente->update($certificado);
            $accionFinal = "Registro actualizado.";
        } catch (ModelNotFoundException $exception) {
            // No se encontró ningún registro con el número de 'documento'. Se creará un nuevo registro.
            self::create($certificado);
            $accionFinal = "Nuevo registro creado.";
        }
    }

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
                'documento' => $estudiante->documento
            ]
        ];

        $rutaGenerada = $this->RutaCarpeta($curso);

        $descargable = $this->generarPDF(
            $datos, // Datos para conformar el certificado.
            "certificados.modelo1", // Vista blade del certificado.
            true, // Determina si la hoja está orientada horizontalmente (True si será horizontal).
            $rutaGenerada // Directorio de ubicación.
        );

        return $this->RutaCarpetaYArchivo($rutaGenerada, $estudiante->documento);
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

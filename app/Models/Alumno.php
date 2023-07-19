<?php

namespace App\Models;

use App\Models\Certificado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Alumno extends Model
{
    protected $fillable = ['nombre', 'apellido', 'documento', 'telefono', 'email'];
    protected $table = "alumnos_admin";
    use HasFactory;

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'id_alumno');
    /**
    * Este método establece la relación "hasMany" entre el modelo actual y el modelo Certificado.
    * Indica que un objeto de este modelo tiene múltiples instancias de Certificado relacionadas
    * a través del campo 'id_alumno'.
    * @return \Illuminate\Database\Eloquent\Relations\HasMany La relación "hasMany" entre el modelo
    * actual y el modelo Certificado.
    */
    }

    public function obtenerIdAlumnoPorDocumento ($documento)
    {
        $alumno = DB::table('alumnos_admin')
            ->where('documento', $documento)
            ->first();

        if ($alumno) {
            return $alumno->id;
        } else {
            return false;
        }
    }

    public function obtenerIdsAlumnosPorDocumentos(array $documentos)
    {
        $alumnos = DB::table('alumnos_admin')
            ->whereIn('documento', $documentos)
            ->get();

        $idAlumnos = [];

        foreach ($alumnos as $alumno) {
            $idAlumnos[$alumno->documento] = $alumno->id;
        }

        return $idAlumnos;
    }


    public function prepararCargaAlumno ($alumno)
    {
        static $numeroFila = 1; // Contador de filas.
        $alumno = [
                'nombre' => mb_convert_case($alumno[0], MB_CASE_TITLE, 'UTF-8'),
                'apellido' => mb_convert_case($alumno[1], MB_CASE_TITLE, 'UTF-8'),
                'documento' => $alumno[2],
                'email' => $alumno[3],
                'telefono' => $alumno[4]
        ];

        $validacion = Validator::make($alumno, [
            'nombre' => ['required', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'regex:/^[\pL\s]+$/u'],
            'documento' => 'required|numeric',
            'email' => 'required|email',
            'telefono' => [
                 'nullable',
                 'regex:/^(?:(?:\+|00)54|0)?(\d{2,4})?(\d{9,11})$/'
                 /**
                  * El patrón de expresión regular para teléfonos acepta los siguientes
                  * formatos para números de teléfono en Argentina:
                  * Números locales (sin código de país ni de área):
                  *  De 7 a 9 dígitos de longitud, por ejemplo, 123456789, 987654321, 1234567890
                  *
                  *  Números con código de país:
                  *      Comienza con +54 o 0054, seguido del formato de número local
                  *      Ejemplos: +54123456789, 0054987654321
                  *
                  *  Números con código de área (incluido el código de área opcional):
                  *      Comienza con 0, seguido de un código de área de 2, 3 o 4 dígitos, y luego
                  * el formato de número local
                  *      Ejemplos: 01112345678, 02234987654, 0290115415233
                  *
                  *  Números con código de país y de área:
                  *      Comienza con +54 o 0054, seguido del código de área y luego el formato de
                  * número local
                  *      Ejemplos: +541112345678, 005402234987654, +54290115415233
                  */
            ]
        ]);

        // Registra los errores de validación, si los hubiese.
        if ($validacion->fails()) {
            $mensajeError = 'Fila inválida de datos. Revisar la siguiente fila en el archivo';
            $mensajeError .= ' (número de fila: ' . $numeroFila . '): ';
            $mensajeError .= $alumno['nombre'] .', '. $alumno['apellido'] .', '. $alumno['documento'] .', '. $alumno['email'] .', '. $alumno['telefono'];
            $mensajeError .= ':';
            foreach ($validacion->errors()->all() as $error) {
                $mensajeError .= ' ' . $error;
            }

            $numeroFila++;
            return ['error' => $mensajeError];
        }

        $numeroFila++;

        return $alumno;
    /**
    * Este método se encarga de preparar los datos de un alumno para su carga en el sistema.
    *
    * Recibe como parámetro un arreglo que contiene los datos del alumno a cargar.
    * El método realiza las siguientes acciones:
    * - Inicializa un contador de filas estático que se utiliza para registrar el número de fila en caso de error de
    * validación.
    * - Los datos de nombre y apellido del alumno son convertidos en sus primeras letras a mayúscula utilizando la
    * función mb_convert_case().
    * - Realiza la validación de los datos del alumno utilizando un objeto de validación.
    * - Si la validación falla, se genera un mensaje de error que incluye el número de fila, los datos inválidos y
    * el error de validación.
    * - Incrementa el número de fila.
    * - Retorna un arreglo con un índice "error" que contiene el mensaje de error en caso de validación fallida.
    * - Si la validación es exitosa, prepara una matriz de datos para la carga del alumno.
    * - Retorna la matriz de datos del alumno preparada para la carga.
    * @author Leandro Brizuela.
    * @param array $alumno Matriz que contiene los datos del alumno a cargar.
    * @return array Una matriz de datos del alumno preparada para la carga, o una matriz con un índice "error"
    * en caso de validación fallida.
    */
    }

    public function cargarAlumnos (array $alumnos)
    {
        $contarActualizados = 0;
        $contarCreados = 0;

        foreach ($alumnos as $alumno) {
            try {
                // Intentar encontrar el registro por 'documento'. Actualizar registro.
                $alumnoExistente = self::where('documento', $alumno['documento'])->firstOrFail();
                $alumnoExistente->update($alumno);
                $contarActualizados++;
            } catch (ModelNotFoundException $exception) {
                // No se encontró ningún registro con el número de 'documento'. Se creará un nuevo registro.
                self::create($alumno);
                $contarCreados++;
            }
        }

        return [
            'creados' => $contarCreados,
            'actualizados' => $contarActualizados
        ];
    /**
    * Este método se encarga de cargar una lista de alumnos en el sistema.
    * Recibe como parámetro una matriz de alumnos.
    *
    * El método realiza las siguientes acciones:
    *  - Inicializa contadores para el número de alumnos actualizados y creados.
    *  - Recorre cada elemento de la matriz de alumnos.
    *  - Intenta encontrar un registro de alumno existente en la base de datos utilizando el campo 'documento'.
    *  - Si se encuentra un registro existente, se actualiza con los datos en $alumno y se incrementa el contador
    * de alumnos actualizados.
    *  - Si no se encuentra ningún registro con el número de 'documento', se crea un nuevo registro con los datos
    * del alumno y se incrementa el contador de alumnos creados.
    *  - Retorna un arreglo con las estadísticas de la carga, incluyendo el número de alumnos creados y actualizados.
    * @author Leandro Brizuela
    * @param array $alumnos Arreglo que contiene los datos de los alumnos a cargar.
    * @return array Estadísticas de la carga de alumnos, incluyendo el número de alumnos creados y actualizados.
    **/
    }

    public function cargarAlumno (array $alumno)
    {
        $accionFinal = "N/A";

        try {
            // Intentar encontrar el registro por 'documento'. Actualizar registro.
            $alumnoExistente = self::where('documento', $alumno['documento'])->firstOrFail();
            $alumnoExistente->update($alumno);
            $accionFinal = "Registro actualizado.";
        } catch (ModelNotFoundException $exception) {
            // No se encontró ningún registro con el número de 'documento'. Se creará un nuevo registro.
            self::create($alumno);
            $accionFinal = "Nuevo registro creado.";
        }

        return $accionFinal;
    /**
    * Este método se encarga de cargar un alumno en el sistema.
    * Recibe como parámetro una matriz de alumnos.
    *
    * El método realiza las siguientes acciones:
    *  - Intenta encontrar un registro de alumno existente en la base de datos utilizando el campo 'documento'.
    *  - Si se encuentra un registro existente, se actualiza con los datos en $alumno y se incrementa el contador
    * de alumnos actualizados.
    *  - Si no se encuentra ningún registro con el número de 'documento', se crea un nuevo registro con los datos
    * del alumno y se incrementa el contador de alumnos creados.
    *  - Retorna un escueto mensaje que indicará si los datos han sido actualizados o creados.
    * @author Leandro Brizuela
    * @param array $alumnos Arreglo que contiene los datos de los alumnos a cargar.
    * @return string $accionFinal Cadena de caracteres que indica si un nuevo registro ha sido creado o actualizado.
    **/
    }
}

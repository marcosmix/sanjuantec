<?php

namespace App\Imports;

use App\Models\Alumno;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class EstudiantesImport implements ToModel, WithValidation
{
    use Importable;

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'regex:/^[\pL\s]+$/u'], // Nombre
            'apellido' => ['nullable', 'regex:/^[\pL\s]+$/u'], // Apellido
            'documento' => 'required|numeric', // Documento
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
            ], // Teléfono
            'email' => 'required|email' // E-mail
        ];
    /**
     * Esta función utiliza las reglas de validación que son empleadas por la función model().
     * Estas reglas permiten validar los datos de la lista de destinatarios de correos.
     * Gracias a estas reglas, se garantiza la integridad de los datos ingresados en la lista de destinatarios.
     * @author Leandro Brizuela
     * @param array
     * @return array
     */
    }


    public function model (array $fila)
    {
        static $numeroFila = 1; // Contador de filas.

        // Conforma matriz de datos para validar y luego cargar o actualizar datos de alumno según el documento.
        $alumno = [
            'nombre' => mb_convert_case($fila[0], MB_CASE_TITLE, 'UTF-8'),
            'apellido' => mb_convert_case($fila[1], MB_CASE_TITLE, 'UTF-8'),
            'documento' => $fila[2],
            'telefono' => $fila[3],
            'email' => $fila[4]
        ];

        // Validar datos.
        $validacion = Validator::make($alumno, $this->rules());

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
        } //TODO BEGIN Aquí puede ir la inserción/actualización de registros de alumnos_admin (base de datos).
        $alumnoModel = new Alumno();
        $alumnoModel->cargarAlumno($alumno);
        // END

        // Crear nuevo objeto con datos que serán utilizados para la creación de certificados.

        $estudiante = new Alumno([
            'nombre' => $alumno['nombre'],
            'apellido' => $alumno['apellido'],
            'documento' => $alumno['documento'],
            'telefono' => $alumno['telefono'],
            'email' => $alumno['email']
        ]);

        $numeroFila++;

        return $estudiante;
     /**
     * Esta función se encarga de construir un objeto de datos utilizando el listado de destinatarios
     * de correos electrónicos con certificados que se encuentra en formato Excel.
     * Se optó por normalizar el nombre y apellido con mayúscula en la primera letra, utilizando el método mb_convert_case().
     * @author Marcos Caballero, Leandro Brizuela.
     * @param array $fila Fila del archivo excel.
     * @return object Estudiante || array Matriz con mensajes de error de validación.
     */
    }

    public function toArray($archivo, $parametrosExtra = [])
    {
        $hojaDeExcel = IOFactory::load($archivo);
        $hojaActiva = $hojaDeExcel->getActiveSheet();
        $filas = $hojaActiva->toArray();

        $estudiantes = [];
        foreach ($filas as $fila) {
            $estudiantes[] = $this->model($fila);
        }

        return $estudiantes;
    /**
     * Convierte un archivo de Excel en una matriz de estudiantes.
     * @author Leandro Brizuela
     * @param string $archivo Ruta o archivo de Excel a cargar.
     * @param array $parametrosExtra Parámetros adicionales (opcional).
     * @return array $estudiantes Matriz de estudiantes.
     * @throws \Exception Si ocurre algún error durante la conversión.
     */
    }
}



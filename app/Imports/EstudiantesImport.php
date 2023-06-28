<?php

namespace App\Imports;

use App\Models\Estudiante;
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
            '0' => ['nullable', 'regex:/^[\pL\s]+$/u'], // Nombre
            '1' => ['nullable', 'regex:/^[\pL\s]+$/u'], // Apellido
            '2' => 'required|numeric', // DNI
            '3' => [
                 'nullable',
                 'regex:/^(?:(?:\+|00)54|0)?(\d{2,4})?(\d{7})$/'
            ], // Celular
            '4' => 'required|email' // E-mail
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
        $validacion = Validator::make($fila, $this->rules());

        if ($validacion->fails()) {
            $mensajeError = 'Fila inválida de datos. Revisar la siguiente fila en el archivo (número de fila: ' . $numeroFila . '): ' . print_r($fila, true);
            $numeroFila++;
            return ['error' => $mensajeError];
        }

        $estudiante = new Estudiante([
            'nombre' => mb_convert_case($fila[0], MB_CASE_TITLE, 'UTF-8'),
            'apellido' => mb_convert_case($fila[1], MB_CASE_TITLE, 'UTF-8'),
            'dni' => $fila[2],
            'celular' => $fila[3],
            'email' => $fila[4]
        ]);

        $numeroFila++;

        return $estudiante;
     /**
     * Esta función se encarga de construir un objeto de datos utilizando el listado de destinatarios
     * de correos electrónicos con certificados que se encuentra en formato Excel.
     * Se optó por normalizar el nombre y apellido con mayúscula en la primera letra, utilizando el método mb_convert_case().
     * @author Marcos Caballero, Leandro Brizuela.
     * @param array $fila Fila del archivo excel.
     * @return object Estudiante
     * @throws \Exception Si ocurre algún error durante la validación.
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



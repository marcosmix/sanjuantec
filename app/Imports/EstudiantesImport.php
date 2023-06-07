<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class EstudiantesImport implements ToModel, WithValidation
{
    use Importable;

    public function rules(): array
    {
        return [
            '0' => ['nullable', 'regex:/^[\pL\s]+$/u'], // Nombre
            '1' => ['nullable', 'regex:/^[\pL\s]+$/u'], // Apellido
            '2' => 'required|numeric', // DNI
            '3' => 'required|numeric', // Celular
            '4' => 'required|email', // E-mail
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


    public function model (array $row)
    {
        $validacion = Validator::make($row, $this->rules());

        if ($validacion->fails()) {
            throw new \Exception('Fila inválida de datos. Revisar el archivo.');
        }

        return new Estudiante([
            'nombre' => $row[0],
            'apellido' => $row[1],
            'dni' => $row[2],
            'celular' => $row[3],
            'email' => $row[4],
        ]);
    /**
     * Esta función se encarga de construir un objeto de datos utilizando el listado de destinatarios
     * de correos electrónicos con certificados que se encuentra en formato Excel.
     * @author Marcos Caballero, Leandro Brizuela.
     * @param array $row Fila del archivo excel.
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



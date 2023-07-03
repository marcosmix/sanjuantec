<?php

namespace App\Console\Commands;

use App\Models\Alumno;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class CargarAlumnosCommand extends Command
{
    /**
     * El nombre y firma del comando de consola.
     * @var string
     */
    protected $signature = 'import:cargaralumnos {ruta}';

    /**
     * Descripción del comando de consola.
     * @var string
     */
    protected $description = 'El comando "CargarAlumnosCommand" importa datos de alumnos desde un archivo Excel y los almacena en
     la tabla "alumnos_admin" de la base de datos. Para asegurar una carga exitosa de datos, se deben cumplir los siguientes requisitos:
    - El archivo Excel no debe contener cabeceras en la primera fila.
    - El orden de las columnas debe ser: nombre, apellido, número de documento, email y teléfono.
    - El nombre y apellido deben ser cadenas de caracteres con una longitud máxima de 125 caracteres.
    - El número de documento debe ser un valor numérico entero sin puntuación ni separación.
    - El email debe tener el formato adecuado de una dirección de correo electrónico y una longitud máxima de 125 caracteres.
    - El teléfono debe ser un número sin caracteres especiales como paréntesis, guiones o espacios, y puede contener un código de área.

    Asegúrese de que el archivo Excel cumpla con estos requerimientos para garantizar una carga correcta de los datos de los alumnos.';

    /**
     * Ejecutar el comando de consola.
     * @return int
     */
    public function handle()
    {
        $descripcion = $this->description;
        $this->comment("Descripción del comando: $descripcion");
        $ruta = $this->argument('ruta');
        $filas = Excel::toArray([], $ruta)[0]; // Leer todas las filas del archivo Excel.
        $alumnoModel = new Alumno();

        foreach ($filas as $fila) {
            // prepararCargaAlumno() valida y prepara cada registro.
            $alumnos[] = $alumnoModel->prepararCargaAlumno($fila);
        }

        foreach ($alumnos as $alumno) {
            // Detectar errores de validación.
            if (isset($alumno['error'])) {
                $erroresDeValidacion = str_replace('\n', '', json_encode($alumno['error'], JSON_UNESCAPED_UNICODE));
            }
        }

        if (isset($erroresDeValidacion)) {
            $this->error('Se han encontrado datos inválidos.');
            $this->line($erroresDeValidacion);
        } else {
            $this->info('Sin errores de validación. Iniciando carga de datos.');
            $resultado = $alumnoModel->cargarAlumnos($alumnos);
            $this->info('Registros creados: '. $resultado['creados'] .'.');
            $this->info('Registros actualizados: '. $resultado['actualizados'] .'.');
            $this->info('Carga de datos completada.');
        }
    }
}

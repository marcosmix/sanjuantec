<?php

namespace App\Http\Controllers;

use App\container\MensajesContainer;
use App\Helpers\CursaTec;
use App\Imports\EstudiantesImport;
use App\Jobs\EnviarEmailJob;
use App\Jobs\ProcesarCertificado;
use App\Models\Curso;
use App\container\ProgramasContainer;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index ()
    {
        $cursos = Curso::all();
        return view("cursos.cardCurso", compact("cursos"));
    }

    public function crearPlantilla ()
    {
        $rutaDeAccion = 'guardarPlantilla'; // Ruta de acción del formulario.
        $programas = ProgramasContainer::listar();
        return view("cursos.crearPlantilla", compact('programas', 'rutaDeAccion'));
    }

    public function generarOtrosCertificados ()
    {
         $importarListado = true;
         $programas = ProgramasContainer::listar();
         $rutaDeAccion = 'guardarPlantillaYCertificados';
         $titulo = "Crear Plantilla de Curso";

         return view("cursos.crearPlantilla", compact('importarListado', 'programas', 'rutaDeAccion', 'titulo'));
    }

    public function guardarPlantilla (Request $request)
    {
        $resultado = Curso::validarYCrearCurso($request);
        $rutaDeAccion = $request->rutaDeAccion; // Ruta de acción del formulario.

        if (isset($resultado['errores_de_validacion'])) {
            $programas = ProgramasContainer::listar();
            return view("cursos.crearPlantilla",
                        compact('programas', 'rutaDeAccion'))
                        ->withErrors($resultado['errores_de_validacion']);
        }

        return redirect(route("plantillas"));
    }

    public function guardarPlantillaYCertificados (Request $request)
    {
        $importarListado = true;
        $resultado = Curso::validarYCrearCurso($request);
        $rutaDeAccion = $request->rutaDeAccion; // Ruta de acción del formulario.
        $tieneFirmas = $request->tieneFirmas;

        if (isset($resultado['errores_de_validacion'])) {
            $programas = ProgramasContainer::listar();
            return view("cursos.crearPlantilla",
                        compact('importarListado', 'programas', 'resultado', 'rutaDeAccion'))
                        ->withErrors($resultado['errores_de_validacion']);
        }

        $curso = $resultado->toArray();
        $datos = EstudiantesImport::validarYProcesarExcel($request);

        if (!empty($datos['errores_de_validacion'])) {
            return redirect()->route('plantillas')->withErrors($datos['errores_de_validacion']);
        }

        $listado = isset($datos['listado'])
                    ? $datos['listado']
                    : exit('Error de '.__FUNCTION__.' ubicado en '.__FILE__.'.');


        // Guardado iterativo de certificados en segundo plano, procesado por lotes.
        $tarea = new ProcesarCertificado($curso, $listado, $tieneFirmas);
        dispatch($tarea);

        // Obtener mensaje.
        $mensaje = MensajesContainer::difusionMarketing();

        // Envío, en segundo plano e iterativo, de emails con certificados.
        if ((isset($request->enviarEmail)) && ($request->enviarEmail == true)) {
            $tarea = new EnviarEmailJob($curso, $mensaje, $listado);
            dispatch($tarea);
        }

        return redirect()->route('administrarCertificados');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect(route("cursos.index"));
    }

    public function mostrarCursos()
    {
        $cursaTec = new CursaTec();
        $cursos = $cursaTec->obtenerCursos();

        foreach ($cursos as $curso) :
            var_dump($curso); echo "<br><hr>";
        endforeach;
    /**
     * Este método obtiene todos los cursos que están presentes en Moodle/CursaTec.
     * TODO Ha sido creado para poner a prueba la integración con la funcionalidad
     * de Servicios Externos de Moodle.
     * @author Leandro Brizuela
     * @date 23 de mayo de 2023.
     */
    }
}

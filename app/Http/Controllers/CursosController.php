<?php

namespace App\Http\Controllers;

use App\Helpers\CursaTec;
use App\Models\Curso;
use App\container\ProgramasContainer;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view("cursos.cardCurso", compact("cursos"));
    }

    public function crearPlantilla ()
    {
        $programas = ProgramasContainer::listar();
        return view("cursos.crearPlantilla", compact('programas'));
    }

    public function generarOtrosCertificados ()
    {
         $titulo = "Crear Plantilla de Curso";
         $importarListado = true;
         $programas = ProgramasContainer::listar();
         return view("cursos.crearPlantilla", compact('importarListado', 'programas', 'titulo'));
    }

    public function guardarPlantilla (Request $request)
    {
        $resultado = Curso::validarYCrearCurso($request);

        if (isset($resultado['errores_de_validacion'])) {
            $programas = ProgramasContainer::listar();
            return view("cursos.crearPlantilla", compact('programas'))->withErrors($resultado['errores_de_validacion']);
        }

        return redirect(route("plantillas"));
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

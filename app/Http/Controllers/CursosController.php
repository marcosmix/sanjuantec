<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\container\ProgramasContainer;
use App\Helpers\CursaTec;

class CursosController extends Controller
{
    public function index()
    {
        $programas = ProgramasContainer::listar();
        $cursos = Curso::all();

        return view("cursos.index", compact("cursos", "programas"));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $nuevo_curso = new Curso();
        $nuevo_curso->create([
            "nombre" => $request->nombre,
            "texto" => $request->texto,
            "duracion" => $request->duracion,
            "fecha" => $request->fecha,
            "bloque" => $request->bloque,
            "programa_id" => $request->programa_id,
        ]);

        return redirect(route("cursos.index"));
    }

    public function show(Curso $curso)
    {
    }

    public function edit(Curso $curso)
    {
    }

    public function update(Request $request, Curso $curso)
    {
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
     * Este método obtiene todos los cursos que están presentes en Moodle/CursaTec. Ha sido creado para poner
     * a prueba la integración con la funcionalidad de Servicios Externos de Moodle.
     * @author Leandro Brizuela
     * @date 23 de mayo de 2023.
     */
    }
}

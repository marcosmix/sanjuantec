<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\container\ProgramasContainer;

class CursosController extends Controller
{
    public function index(){
    $programas=ProgramasContainer::listar();
        $cursos=Curso::all();


        return view('cursos.index',compact('cursos', 'programas'));
    }

   
    public function create(){
        
    }

    public function store(Request $request){

        $nuevo_curso=new Curso;
        $nuevo_curso->create([
            'nombre'=>$request->nombre,
            'texto'=>$request->texto,
            'duracion'=> $request->duracion,
            'fecha'=> $request->fecha,
            'bloque' => $request->bloque,
            'programa_id'=>$request->programa_id
        ]);

        return redirect(route('cursos.index'));
    }

    
    public function show(Curso $curso){
    }

    public function edit(Curso $curso){
    }

    public function update(Request $request, Curso $curso){
    }

    public function destroy(Curso $curso){
        $curso->delete();
        return redirect(route('cursos.index'));
    }
}

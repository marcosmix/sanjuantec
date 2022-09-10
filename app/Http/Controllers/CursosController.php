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

   
    public function create()
    {
        //
    }

    public function store(Request $request){

        $nuevo_curso=new Curso;
        $nuevo_curso->create([
            'nombre'=>$request->nombre,
            'texto'=>$request->texto,
            'programa_id'=>$request->programa_id
        ]);

        return redirect(route('cursos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso){
        $curso->delete();
        return redirect(route('cursos.index'));
    }
}

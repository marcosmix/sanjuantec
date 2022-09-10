<?php

namespace App\Http\Controllers;

use App\Imports\EstudiantesImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use App\Models\Curso;

use App\helpers\pdf;
class CertificadoController extends Controller{
 
    use pdf;
    public function index($curso_id){
        $curso=Curso::find($curso_id);
        return view('certificados.index',compact('curso'));
    }

    public function generar(Request $request){
       // $listado=Excel::import(new EstudiantesImport,request()->file('listado')); 
       $listado=(new EstudiantesImport)->toArray(request()->file('listado'));
       $curso=['nombre'=>$request->nombre,'texto'=>$request->texto];
    
       $this->procesarEstudiantes($curso,$listado[0]);
       return redirect(route('cursos.index'));
    }

    public function GenerarRutaPDF($curso,$estudiante){
        return "certificados/".$curso['nombre']."/".strval($estudiante['dni']).".pdf";
    }

    public function procesarEstudiantes($curso, $listado){
        foreach($listado as $estudiante){
            $e=['nombre'=> $estudiante[0],
               'apellido'=>$estudiante[1],
               'dni' => $estudiante[2]];

            $this->generarPDF(['estudiante'=>$e,'curso'=>$curso],
                               'certificados.modelo1',
                               true,
                               $this->GenerarRutaPDF($curso,$e));
        }
        
    }
}

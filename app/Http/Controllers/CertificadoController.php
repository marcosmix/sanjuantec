<?php

namespace App\Http\Controllers;

use App\Imports\EstudiantesImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use App\Models\Curso;

use App\helpers\gpdf;

use function Termwind\terminal;

class CertificadoController extends Controller{
 
    use gpdf;
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

    public function testearVistaPDF(){
        $datos =["estudiante"=> [
                                    'nombre' => "Marcos",
                                    'apellido' => "Caballero",
                                    'dni' => "35849098"
                                ],
                "curso"=>['texto'=>'ha participado del curso teorico-practico demonomidado',
                        'duracion'=>'con una duracion de 3 meces',
                        'subprograma'=>'perteneciente al sub programa Talento Tec',
                        'nombre'=>'Fundamentos de Laravel',
                        'fecha'=>'San Juan a los 25 dias de Abril de 2022']

                ];

        $this->generarPDF([],
            'certificados.mod1',true,$this->GenerarRutaPDF($datos['curso'], $datos['estudiante'])
        );
        return view('certificados.mod1',compact('datos'));
    }

    public function procesarEstudiantes($curso, $listado){
        foreach($listado as $estudiante){
            $e=['nombre'=> $estudiante[0],
               'apellido'=>$estudiante[1],
               'dni' => $estudiante[2]];

            $this->generarPDF(['estudiante'=>$e,'curso'=>$curso],
                               'certificados.mod1',
                               true,
                               $this->GenerarRutaPDF($curso,$e));
        }
        
    }
}

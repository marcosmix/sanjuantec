<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\helpers\MailTec;

use App\helpers\rutas;
use App\Imports\EstudiantesImport;
use App\container\MensajesContainer;
class DifusionController extends Controller
{
    use rutas;

    public function index(){
        return view('difusion.index');
    }

    public function CargarContactos(){
        $cursos=Curso::all();
        return view('difusion.enviarCertificados',compact('cursos'));
    }
    
    public function EnviarCertificados(Request $request){
        $listado = (new EstudiantesImport)->toArray(request()->file('contactos'));
        $curso = Curso::where('nombre',$request->curso)->first()->toArray();
        $mensaje =MensajesContainer::difusionMarketing();
        foreach($listado[0] as $estudiante)
         MailTec::EnviarMailCertificados($this->rowToArray($estudiante),$curso,$mensaje);
 
       return redirect()->back();

    }

    public function rowToArray($estudiante){
        return [
                'nombre'=>$estudiante[0],
                'apellido'=>$estudiante[1],
                'dni'=>$estudiante[2],
                'email' => $estudiante[4],
        ];
    }
   
}

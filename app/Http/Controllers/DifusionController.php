<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\MailTec;
use App\Helpers\rutas;
use App\Imports\EstudiantesImport;
use App\Imports\CursatecImport;
use App\container\MensajesContainer;
use App\Imports\CursatecImportFULL;

class DifusionController extends Controller
{
    use rutas;

    public function index()
    {
        return view("difusion.index");
    }

    public function EnviarMensajePOST(Request $request)
    {
        $listado = (new CursatecImportFULL())->toArray(
            $request->file("contactos")
        );
        foreach ($listado[0] as $estudiante) {
            dump($estudiante);
            MailTec::EnviarCuentasCursatec(
                $this->rowToArrayCursatecCuentas($estudiante)
            );
        }

        return redirect()->back();
    }

    public function EnviarMensaje()
    {
        return view("difusion.mensajes");
    }

    public function generarCertificados(Request $request)
    {
        $titulo = "Certificados de cursos";
        $datos = $request->input('datos');

        $vista1 = view('base', compact('titulo'));
        $vista2 = view("difusion.importarContactos", compact('datos'));

        $vistaConcatenada = $vista1->render() . $vista2->render();
        // TODO Aquí deberán ser implementadas las siguientes funcionalidades:
        // - El llamado a otro método que generará los certificados.
        // - El llamado a otro método que guardará los certificados (base de datos (+ ¿pdf?)).
        // - El llamado a otro método que enviará el certificado vía email a cada alumno de un curso determinado.

        return $vistaConcatenada;
        // return view("difusion.importarContactos", compact('datos'));
    }

    public function generarCertificadosPorCurso()
    {
        $titulo = "Certificados de cursos";
        $cursos = Curso::all();
        // TODO Aquí deberán ser implementadas las siguientes funcionalidades:
        // - El llamado a otro método que generará los certificados.
        // - El llamado a otro método que guardará los certificados (base de datos (+ ¿pdf?)).
        // - El llamado a otro método que enviará el certificado vía email a cada alumno de un curso determinado.

        return view("difusion.enviarCertificados", compact('cursos', 'titulo'));
    }

    public function EnviarCertificados(Request $request)
    {
        $listado = (new EstudiantesImport())->toArray(
            request()->file("contactos")
        );
        $curso = Curso::where("nombre", $request->curso)
            ->first()
            ->toArray();
        $mensaje = MensajesContainer::difusionMarketing();
        foreach ($listado[0] as $estudiante) {
            MailTec::EnviarMailCertificados(
                $this->rowToArray($estudiante),
                $curso,
                $mensaje
            );
        }

        return redirect()->back();
    }

    public function rowToArray($estudiante)
    {
        return [
            "nombre" => $estudiante[0],
            "apellido" => $estudiante[1],
            "dni" => $estudiante[2],
            "email" => $estudiante[4],
        ];
    }

    public function rowToArrayCursatecCuentas($estudiante)
    {
        return [
            "nombre" => $estudiante[3],
            "user" => $estudiante[0],
            "pass" => $estudiante[1],
            "email" => $estudiante[2],
        ];
    }
}

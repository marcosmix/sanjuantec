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
        $datos = $request->input('datos');
        // TODO Aquí deberán ser implementadas las siguientes funcionalidades:
        // - El llamado a otro método que guardará los certificados (base de datos (+ ¿pdf?)).
        // - El llamado a otro método que generará los certificados.
        // - El llamado a otro método que enviará email a los alumnos de un curso determinado.

        return view("difusion.enviarCertificados", compact('datos'));
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

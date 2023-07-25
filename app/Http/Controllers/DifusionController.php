<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Jobs\ProcesarCertificado;
use App\Jobs\EnviarEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\MailTec;
use App\Helpers\rutas;
use App\Imports\EstudiantesImport;
use App\Imports\CursatecImport;
use App\Imports\CursatecImportFULL;
use App\container\MensajesContainer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DifusionController extends Controller
{
    use rutas;

    public function index()
    {
        $cursos = Curso::all();
        return view("cursos.cardCurso", compact("cursos"));
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

    public function prepararEnvioCertificados (Request $request)
    {
        $titulo = "Certificados de cursos";
        $datos = $request->input('datos');

        $vista1 = view('base', compact('titulo'));
        $vista2 = view("difusion.importarContactos", compact('datos'));
        $vistaConcatenada = $vista1->render() . $vista2->render();

        return $vistaConcatenada;
    }

    public function EnviarCertificados (Request $request)
    {
        // Primera validación: Comprobar extensión del archivo subido.
        $validacion = Validator::make($request->all(), [
            'contactos' => 'required|file|mimes:xlsx',
        ]);

        if ($validacion->fails()) {
            return redirect()->route('plantillas')->withErrors($validacion);
        }

        // Obtener, del Excel, una matriz de alumnos destinatarios.
        $listado = (new EstudiantesImport())->toArray($request->file("contactos"));

        // Segunda validación: Comprobar la integridad de los datos.
        $erroresDeValidacion = [];
        foreach ($listado as $estudiante) {
            if (isset($estudiante['error'])) {
                $erroresDeValidacion[] = $estudiante['error'];
            }
        }

        if (!empty($erroresDeValidacion)) {
            return redirect()->route('plantillas')->withErrors($erroresDeValidacion);
        }

        // Obtener datos del curso, según su nombre.
        $curso = Curso::where("nombre", $request->curso)
            ->first()
            ->toArray();

        // Guardado iterativo de certificados en segundo plano, procesado por lotes.
        $tarea = new ProcesarCertificado($curso, $listado);
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

    public function generarCertificadosPorCurso()
    {
        $titulo = "Certificados de cursos";
        $cursos = Curso::all();
        return view("difusion.enviarCertificadosPorCurso", compact('cursos', 'titulo'));
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

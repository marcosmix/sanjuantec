<?php

namespace App\Http\Controllers;

use App\Helpers\MailTec;
use App\Helpers\rutas;
use App\Imports\CursatecImport;
use App\Imports\CursatecImportFULL;
use App\Imports\EstudiantesImport;
use App\Jobs\EnviarEmailJob;
use App\Jobs\ProcesarCertificado;
use App\Models\Curso;
use App\container\MensajesContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function EnviarCertificados (Request $request, $tieneFirmas = true)
    {
        $datos = EstudiantesImport::validarYProcesarExcel($request);

        if (!empty($datos['errores_de_validacion'])) {
            return redirect()->route('plantillas')->withErrors($datos['errores_de_validacion']);
        }

        $listado = isset($datos['listado'])
                    ? $datos['listado']
                    : exit('Error de '.__FUNCTION__.' ubicado en '.__FILE__.'.');

        // Obtener datos del curso, según su nombre.
        $curso = Curso::where("nombre", $request->curso)->first()->toArray();

        // Guardado iterativo de certificados en segundo plano, procesado por lotes.
        $tarea = new ProcesarCertificado($curso, $listado, $tieneFirmas);
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

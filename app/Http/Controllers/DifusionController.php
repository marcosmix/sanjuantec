<?php

namespace App\Http\Controllers;

use App\Helpers\gpdf;
use App\Helpers\MailTec;
use App\Helpers\rutas;
use App\Imports\CursatecImport;
use App\Imports\CursatecImportFULL;
use App\Imports\EstudiantesImport;
use App\Jobs\EnviarEmailJob;
use App\Jobs\ProcesarCertificado;
use App\Models\Alumno;
use App\Models\Certificado;
use App\Models\Curso;
use App\Models\MailEnviado;
use App\container\MensajesContainer;
use App\container\ProgramasContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DifusionController extends Controller
{
    use rutas, gpdf;

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

    public function enviarCertificados (Request $request, $tieneFirmas = true)
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
        if ($request->filled('enviarEmail') && $request->boolean('enviarEmail')) {
            $tarea = new EnviarEmailJob($curso, $mensaje, $listado);
            dispatch($tarea);
        }

        return redirect()->route('administrarCertificados');
    }

    public function enviarCertificadoPorAlumno (Request $request)
    {
        // Validar datos de alumno. Si no hay problemas, se guardará en la base de datos.
        $alumnoModel = new Alumno();
        $alumno = $request->alumno;
        $alumnoValidado = $alumnoModel->prepararCargaAlumno($alumno);

        if (!empty($alumnoValidado['error'])) {
            return redirect()->route('generarCertificadoPorAlumno')->withErrors($alumnoValidado['error']);
        }

        $alumnoModel->cargarAlumno($alumnoValidado);
        $alumnoValidado = (object) $alumnoValidado;
        $idAlumno = Alumno::obtenerIdAlumnoPorDocumento($alumnoValidado->documento);

        // Validar datos de curso. Si no hay problemas, se guardará en la base de datos.
        $datosCurso = Curso::validarYCrearCurso($request);

        if (!empty($datosCurso['errores_de_validacion'])) {
            return redirect()->route('generarCertificadoPorAlumno')->withErrors($datosCurso['errores_de_validacion']);
        }

        // Determinar si el certificado deberá incluir firmas.
        $tieneFirmas = false;
        if ($request->filled('tieneFirmas') && $request->boolean('tieneFirmas')) {
            $tieneFirmas = $request->tieneFirmas;
        }

        // Generar certificado PDF. Después, guardar en la base de datos.
        $rutaCompleta = $this->generarCertificadoCursoAlumno($datosCurso->toArray(), $alumnoValidado, $tieneFirmas);
        $certificadoModel = new Certificado();
        $certificadoModel->crearOActualizarCertificados([0 =>
                                                             ['idAlumno' => $idAlumno,
                                                             'directorioCompleto' => $rutaCompleta]
                                                         ],
                                                          $datosCurso->id);

        // Enviar email con mensaje de marketing y certificado adjunto. Luego, registrar en la base de datos el envío
        // del email.
        $mensaje = MensajesContainer::difusionMarketing();

        if ($request->filled('enviarEmail') && $request->boolean('enviarEmail')) {
            $resultado = MailTec::EnviarMailCertificados($alumnoValidado, $datosCurso, $mensaje);

            if ($resultado) {
                $mailEnviado = new MailEnviado();
                $mailEnviado->guardarEmailEnviado($alumnoValidado->documento, $datosCurso->id);
            }
        }

        return redirect()->route('administrarCertificados');
    }

    public function generarCertificadoPorAlumno ()
    {
        $titulo = "Certificado por alumno";
        $programas = ProgramasContainer::listar();
        return view("difusion.enviarCertificadoPorAlumno", compact('programas','titulo'));
    }

    public function generarCertificadosPorCurso ()
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

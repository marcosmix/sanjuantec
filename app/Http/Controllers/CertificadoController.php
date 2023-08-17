<?php

namespace App\Http\Controllers;

use App\Imports\EstudiantesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Certificado;
use App\Models\Curso;
use App\Models\MailEnviado;
use App\Helpers\gpdf;
use App\Helpers\rutas;
use App\Imports\CertificadosEspImport;
use App\Imports\ProyectosImport;
use App\Models\CertificadoEspecial;
use App\container\ProgramasContainer;

class CertificadoController extends Controller
{
    use gpdf, rutas;

    public function index($curso_id)
    {
        $curso = Curso::find($curso_id);
        return view("certificados.index", compact("curso"));
    }

    public function administrarCertificados ()
    {
        $titulo = "Certificados Generados";
        $datosCertificados = Certificado::obtenerCertificadosYMails();
        $cantidadElementos = $datosCertificados->count();
        return view("certificados.administrarCertificados", compact("cantidadElementos","datosCertificados","titulo"));
    /**
     * Este método controlador obtiene datos de certificados y correos electrónicos para ser mostrados en la tabla
     * de la vista de administración y control de certificados y correos electrónicos.
     *
     * @author Leandro Brizuela
     * @return \Illuminate\Contracts\View\View La vista blade que muestra los datos.
     */
    }

    public function generarCertificadoJam(Request $request)
    {
        $listado = (new ProyectosImport())->toArray($request->file("listado"));

        foreach ($listado[0] as $nombre) {
            $this->procesarCertificadosJam($nombre[0]);
        }

        return redirect(route("cursos.index"));
    }

    public function procesarCertificadosJam($nombre_proyecto)
    {
        $this->generarPDF(
            ["nombre_proyecto" => $nombre_proyecto],
            "certificados.certificadoGrupal",
            true,
            "certificados\\jam\\" . $nombre_proyecto . ".pdf"
        );
    }

    public function generar(Request $request)
    {
        // $listado=Excel::import(new EstudiantesImport,request()->file('listado'));
        $listado = (new EstudiantesImport())->toArray(
            request()->file("listado")
        );

        $curso = Curso::find($request->id)->toArray();
        $curso["subprograma"] = ProgramasContainer::verNombreProID(
            $curso["programa_id"]
        );
        //    $curso=['nombre'=>$request->nombre,'texto'=>$request->texto];

        $this->procesarEstudiantes($curso, $listado[0]);
        return redirect(route("cursos.index"));
    }

    public function testearVistaPDF()
    {
        $datos =[
            "estudiante"=> [
                'nombre' => "Marcosio Danielon",
                'apellido' => "Caballeronn Agueriston",
                'documento' => "35.849.098"
            ],
            "curso" =>[
                'texto' => 'ha participado del curso teorico-practico demonomidado',
                'duracion' =>'con una duracion de 3 meses',
                'subprograma' => 'perteneciente al sub programa Talento Tec',
                'bloque' => 'programación',
                'nombre' => ' Fundamentos de Laravel',
                'fecha' => 'San Juan a los 25 dias de Abril de 2022'],
            "tieneFirmas" => false
            ];

        $this->generarPDF($datos,
            'certificados.modelo1',true,$this->GenerarRutaPDF($datos['curso'], $datos['estudiante']['documento'])
        );

        return view("certificados.modelo1", compact("datos"));
    }

    public function procesarEstudiantes($curso, $listado)
    {
        foreach ($listado as $estudiante) {
            $e = [
                "nombre" => $estudiante[0],
                "apellido" => $estudiante[1],
                "dni" => $estudiante[2],
            ];

            $this->generarPDF(
                ["estudiante" => $e, "curso" => $curso],
                "certificados.mod1",
                true,
                $this->GenerarRutaPDF($curso, $e["dni"])
            );
        }
    }

    public function generarCertificadoEspeciales(Request $request)
    {
        $listado = (new CertificadosEspImport())->toArray(
            $request->file("listado")
        )[0];
        $datos_fijos = array_intersect_key(
            $request->all(),
            array_flip(["bloque_organizacion", "fecha"])
        );

        if ($request->firmas == "on") {
            foreach ($listado as $item) {
                $this->generarPDF(
                    CertificadoEspecial::normalizarDatos($item, $datos_fijos),
                    "certificados.certificadoEspecial",
                    true,
                    $this->GenerarRutaPDFv2("especiales", $item[1] . $item[3])
                );
            }
        }
    }
}

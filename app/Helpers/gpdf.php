<?php

namespace App\Helpers;

use App\Helpers\rutas;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

trait gpdf
{
    use rutas;

    public function generarPDF ($datos, $vista, $horizontal = false, $directorio)
    {
        // Inicializar Dompdf con opciones.
        $options = new Options();
        $options->set(['isRemoteEnabled' => true]);
        $dompdf = new Dompdf($options);

        // Compartir datos junto a la vista.
        view()->share($vista, ['datos' => $datos]);

        // Cargar la vista hacia Dompdf.
        $dompdf->loadHtml(view($vista, ['datos' => $datos]));

        // Determinar la orientación a landscape si $horizontal es verdadero.
        if ($horizontal) {
            $dompdf->setPaper('A4', 'landscape');
        }

        // Renderizar pdf.
        $dompdf->render();

        // Obtener el PDF resultante.
        $pdf = $dompdf->output();

        // Crear el directorio si no existe aún.
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }

        // Guardar el archivo PDF en la ruta especificada.
        $locacionArchivo = $directorio . $datos['estudiante']['documento'] . '.pdf';
        file_put_contents($locacionArchivo, $pdf);

        // Devolver el archivo PDF como una respuesta descargable.
        return $locacionArchivo;
    /**
     * Método requerido para la conformación y guardado de certificados PDF.
     * @Autores: Marcos Caballero, Leandro Brizuela.
     * Se ha implementado una nueva funcionalidad para crear directorios en caso de que no existan.
     *
     * @param array $datos Matriz con los datos requeridos para la conformación del PDF.
     * @param string $vista Nombre de la vista Blade. Ejemplo: "certificados.modelo1".
     * @param bool $horizontal Valor lógico que determina la orientación del PDF (horizontal o vertical).
     *                        True para horizontal, false para vertical.
     * @param string $url Directorio desde la raíz de la aplicación donde se almacenará el archivo PDF.
     *
     * @return object Archivo resultante como una respuesta descargable.
     */
    }

    public function generarCertificadoCursoAlumno ($curso, // Matriz
                                                 $estudiante, // Objeto
                                                 $tieneFirmas // Booleano
                                                 )
    {
        $datos = [
            'curso' => [
                'nombre' => $curso['nombre'],
                'texto' => $curso['texto'],
                'duracion' => $curso['duracion'],
                'bloque' => $curso['bloque'],
                'fecha' => $curso['fecha']
            ],
            'estudiante' => [
                'nombre' => $estudiante->nombre,
                'apellido' => $estudiante->apellido,
                'documento' => $estudiante->documento
            ],
            'tieneFirmas' => $tieneFirmas
        ];

        $rutaGenerada = $this->RutaCarpetaStorage($curso);

        $rutaCompleta = $this->generarPDF(
            $datos, // Datos para conformar el certificado.
            "certificados.modelo1", // Vista blade del certificado.
            true, // Determina si la hoja está orientada horizontalmente (True si será horizontal).
            $rutaGenerada // Directorio de ubicación.
        );

        return $rutaCompleta; // TODO BEGIN La ruta absoluta es la guardada en la base de datos. ¿Esto es correcto? END
    /**
     * Este método conforma la estructura de datos necesaria para generar un certificado en formato PDF.
     * TODO BEGIN
     * La vista Blade utilizada como plantilla general es certificados.modelo1. Es posible que una nueva vista
     * sea requerida para la generación de nuevos certificados END
     * @name generarCertificadosPorCurso()
     * @author Leandro Brizuela.
     * @param array $curso Matriz con datos de un curso.
     * @param object $estudiante Objeto de datos con los datos de cada alumno/destinatario.
     * @return bool True si no ocurrió una interrupción inesperada.
     */
    }

    /**
     * @author Leandro Brizuela
     * @date 17 de julio de 2023.
     * @name generarCertificadoJam()
     * La función permanecerá comentada hasta nuevo aviso.
     */
    // public function generarCertificadoJam($nombre_proyecto)
    // {

    //     //inicio optimizar esta parte
    //     $options = new Options();
    //     $options->set(['isRemoteEnabled' => true]);

    //     $dompdf = new Dompdf($options);

    //     view()->share($vista, ['datos' => $datos]);
    //     $dompdf->loadhtml(view($vista, ['datos' => $datos]));


    //     if ($horizontal)
    //         $dompdf->setPaper('A4', 'landscape');

    //     $dompdf->render();
    //     $output = $dompdf->output();
    //     //fin optimizar esta parte

    //     view()->share($vista, ['datos' => $datos]);
    //     $pdf = Pdf::loadView($vista, ['datos' => $datos]);
    //     $pdf->setPaper('A4', 'landscape');
    //     $pdf->render();
    //     $output = $pdf->output();

    //     Storage::disk('public')->put($url, $output);
    //     //  $dompdf->stream($url, array('Attachment' => false));
    //     //file_put_contents($url, $output);

    //     return $pdf->download('$url');
    // }
}
?>

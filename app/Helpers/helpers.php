<?php

use Illuminate\Support\Facades\File;

if (!function_exists('base64ConvertirImagen')) {
    /**
     * Codifica una imagen en base64. Se recurre a esta codificación solamente porque la carga directa de imágenes
     * no funcionaba con domPDF.
     * @author Leandro Brizuela
     * @param string $directorio La ubicación de la imagen en el sistema de archivos.
     * @return string La representación base64 de la imagen con el encabezado MIME correspondiente.
     */
    function base64ConvertirImagen ($directorio)
    {
        // Obtener el contenido del archivo.
        $contenidoArchivo = File::get($directorio);

        // Codificar el contenido del archivo en base64.
        $base64 = base64_encode($contenidoArchivo);

        // Obtener el tipo MIME de la imagen.
        $mime = File::mimeType($directorio);

        // Devolver la representación de la imagen en base64 con el encabezado MIME correspondiente.
        return "data:$mime;base64,$base64";
    }
}



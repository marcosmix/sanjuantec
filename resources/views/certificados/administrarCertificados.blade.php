@extends('base')
@section('content')
<!-- Tabla de administración de certificados.  -->
<div class="centrar-tabla">
    <table class="tabla-certificados">
        <thead>
            <tr>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    N°
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Nombre
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Apellido
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Curso
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Enviado
                </th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i < $cantidadElementos; $i++)
            @php $certificado = $datosCertificados[$i]; @endphp
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $certificado->nombreAlumno }}</td>
                <td>{{ $certificado->apellidoAlumno }}</td>
                <td>{{ $certificado->nombreCurso }}</td>
                <td>
                    <div class="circulo @if($certificado->tieneMailEnviado == 1)
                                            circulo-verdadero
                                        @else circulo-falso
                                        @endif">
                    </div>
                </td>
                <td>
                   <a class="boton-2 boton-ver"
                       data-documentoalumno="{{ $certificado->documentoAlumno }}"
                       data-nombrecurso="{{ $certificado->nombreCurso }}"
                       href="#"
                    >
                        Ver
                    </a>
                </td>
                <td><a class="boton-2 boton-enviar">Enviar</a></td>
            </tr>
        @endfor
        </tbody>
        </tr>
    </table>
</div>
<div class="centrar-texto">
    <button type="submit" class="boton boton-alerta margen-superior-60px">Enviar todos los certificados</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const botonVer = new Boton('boton-ver', { verPdf: true });
        botonVer.verPdf();
    });
</script>
@endsection

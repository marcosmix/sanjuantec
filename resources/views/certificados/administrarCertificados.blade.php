@extends('base')
@section('content')
<!-- Mensaje de estado del envío de email. -->
<div class="centrar-texto" id="estado-email"></div>
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
        @for ($i = 0; $i < $cantidadElementos; $i++)
            @php $certificado = $datosCertificados[$i]; @endphp
            <tr>
                <td>{{ $i+1 }}</td>
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
                       href="#">
                       Ver
                    </a>
                </td>
                <td>
                    <a class="boton-2 boton-enviar"
                       data-nombrealumno="{{ $certificado->nombreAlumno }}"
                       data-apellidoalumno="{{ $certificado->apellidoAlumno }}"
                       data-documentoalumno="{{ $certificado->documentoAlumno }}"
                       data-emailalumno="{{ $certificado->emailAlumno }}"
                       data-idcurso="{{ $certificado->idCurso }}"
                       data-nombrecurso="{{ $certificado->nombreCurso }}"
                       href="#">
                       Enviar
                    </a>
                </td>
            </tr>
        @endfor
        </tbody>
        </tr>
    </table>
</div>

<!-- Botón de envío masivo de emails. -->
<div class="centrar-texto">
    <button class="boton boton-alerta margen-superior-60px" id="enviar-certificados" type="button" >Enviar todos los certificados</button>
</div>

<!-- Modal para confirmar envío masivo de emails. -->
<div id="modal-de-confirmacion" class="modal">
    <div class="modal-contenido">
        <span class="cerrar">&times;</span>
        <p>¿Está seguro de que quiere enviar todos los certificados?</p>
        <button id="confirmar-envio" class="boton-confirmar">Confirmar</button>
    </div>
</div>

<script>
    // Boton.js
    document.addEventListener("DOMContentLoaded", function() {
        const botonVer = new Boton('boton-ver', { verPdf: true });
        botonVer.verPdf();
    });
</script>
<script src="/js/Ajax.js"></script>
<script>
    // Funcionalidades Ajax para envíar certificado/s por email.
    var enviarCertificadoUrl = '{{ route('enviarCertificadoPorMetodoAjax') }}';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {
        var datosCertificados = @json($datosCertificados);

        $('#enviar-certificados').on('click', function() {
            $('#modal-de-confirmacion').css('display', 'block');
        });

        $('#confirmar-envio').on('click', function() {
            $('#modal-de-confirmacion').css('display', 'none');
            enviarTodosLosEmails(csrfToken, datosCertificados);
        });

        $('.cerrar').on('click', function() {
            $('#modal-de-confirmacion').css('display', 'none');
        });

        enviarEmail(csrfToken);
    });
</script>
@endsection

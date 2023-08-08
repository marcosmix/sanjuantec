@include('base')
<!-- Mensajes de error de validación en los datos ingresados en el formulario
 de creación de curso o plantilla de certificado de curso. -->
<div class="centrar-texto">
    @if ($errors->any())
        <div class="alerta alerta-error boton centrar-texto">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="listado-errores">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- Formulario de creación de curso o plantilla de certificado de curso. -->
<form class='form-curso' action="{{ route($rutaDeAccion) }}" method="POST" enctype='multipart/form-data'>
    @csrf
    @include('cursos.plantillaCertificadoCurso')
    <br>
    @if (isset($importarListado))
        @include('difusion.importarListado')
    @endif
    <button type="submit" class="boton boton-primario">Guardar</button>
</form>

<div class="centrar-texto">
    <button id="boton-volver" type="submit" class="boton boton-aviso">Volver</button>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const botonVolver = new Boton('boton-volver');
        botonVolver.volver();
    });
</script>

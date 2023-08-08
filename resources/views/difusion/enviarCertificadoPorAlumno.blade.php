@extends('base')
@section('content')
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

<!-- Formulario de carga de datos de alumno y de curso o plantilla de curso. -->
<form action="{{ route('enviarCertificadoPorAlumno')}}" class='form-curso' method="POST" enctype='multipart/form-data'>
    @csrf
    <div class="mb-3">
        <label for="nombreAlumno">Nombre</label>
        <input class="form-control" type="text" id="nombreAlumno" name="alumno[0]" required>
    </div>

     <div class="mb-3">
        <label for="apellido">Apellido</label>
        <input class="form-control" type="text" id="apellido" name="alumno[1]" required>
    </div>

    <div class="mb-3">
        <label for="documento">Documento</label>
        <input class="form-control" type="text" id="documento" name="alumno[2]" required>
    </div>

    <div class="mb-3">
        <label for="email">Email</label>
        <input class="form-control" type="email" id="email" name="alumno[3]" required>
    </div>

    <div class="mb-3">
        <label for="telefono">Teléfono</label>
        <input class="form-control" type="text" id="telefono" name="alumno[4]">
    </div>
    @include('cursos.plantillaCertificadoCurso')
    <br>
    <div class="borde-rojo div-borde-redondeado padding-total-10px">
        <div class="padding-total-10px">
           <label><input type="checkbox" id="checkbox1" name="tieneFirmas" value="true">Firmas de autoridades.</label><br>
        </div>
        <div class="padding-total-10px">
           <label><input type="checkbox" id="checkbox2" name="enviarEmail" value="true">Enviar e-mail después de guardar.</label><br>
        </div>
    </div>
    <br>
    <button class="boton boton-primario" type="submit">Aceptar</button>
</form>

<div class="margen-superior-20px">
    <button id="boton-volver" type="submit" class="boton boton-aviso margen-izquierdo-20px margen-superior-20px">Volver</button>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const botonVolver = new Boton('boton-volver');
        botonVolver.volver();
    });
</script>
@endsection

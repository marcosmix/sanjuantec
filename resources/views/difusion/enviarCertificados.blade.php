@extends('base')
@section('content')
<h3 class="centrar-texto">Certificados de cursos</h3>
<div class="content">
    <form action="{{route('difusion.EnviarCertificados')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            <h3 class="centrar-texto margen-superior-60px">{{ $datos['nombre'] }}</h3>
            <div class="div-borde-redondeado margen-superior-60px padding-total-10px">
                <h3>Listado de alumnos que pertenecen a ese curso</h3>
                <p>El listado de alumnos </p>
                <p>Formato hoja de cálculo con tres columnas: Nombre, apellido, DNI, celular, mail.</p>
                <p>Deben respetar el mismo orden y no se debe colocar encabezado. No pueden faltar los valores de las columnas DNI y email ya que se implementan para realizar el envio, los otros campos pueden estar en blanco.</p>
                <p>Se recomienda usar el mismo archivo con el que generó los certificados</p>
                <input class="boton" type="file" name="contactos" id="listado" required>
            </div>
        </div>
        <br>
        <div class="div-borde-redondeado padding-total-10px">
           <label><input type="checkbox" id="checkbox" name="enviar_email" value="true">Enviar vía e-mail todos los certificados al terminar de generarlos.</label><br>
        </div>
    </form>
</div>

<div class="centrar-texto">
    <button id="boton-volver" type="submit" class="boton boton-aviso margen-superior-20px">Volver</button>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const botonVolver = new Boton('boton-volver');
        botonVolver.volver();
    });
</script>

@endsection

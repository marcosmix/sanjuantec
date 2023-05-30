<div class="content padding-total-10px">
    <form action="{{route('difusion.EnviarCertificados')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            @if (isset($datos['nombre']))
            <h3 class="centrar-texto">{{ $datos['nombre'] }}</h3>
            @endif
            <div class="div-borde-redondeado padding-total-10px">
                <h3>Listado de alumnos que pertenecen a ese curso</h3>
                <p><b>Formato del listado de alumnos:</b> </p>
                <p>La hoja de cálculo debe contener hasta cuatro columnas: Nombre, apellido, DNI, celular, mail.</p>
                <p>Deben respetar el mismo orden y no se debe colocar encabezado. No pueden faltar los valores de las columnas DNI y email ya que se implementan para realizar el envío.<br>
                 Los otros campos pueden estar en blanco.</p>
                <p>Se recomienda usar el mismo archivo con el que generó los certificados.</p>
                <input class="boton" type="file" name="contactos" id="listado" required>
            </div>
        </div>
        <br>
        <div class="div-borde-redondeado padding-total-10px">
           <label><input type="checkbox" id="checkbox" name="enviar_email" value="true">Enviar vía e-mail todos los certificados al terminar de generarlos.</label><br>
        </div>
    </form>
</div>
<!-- TODO Implementar la funcionalidad del botón Generar Certificados. -->
<div class="centrar-texto margen-superior-20px">
    <button type="submit" class="boton boton-alerta margen-superior-20px">Generar Certificados</button>
</div>

<div class="margen-superior-20px">
    <button id="boton-volver" type="submit" class="boton boton-aviso margen-izquierdo-20px margen-superior-20px">Volver</button>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const botonVolver = new Boton('boton-volver');
        botonVolver.volver();
    });
</script>

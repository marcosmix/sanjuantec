<div class="content padding-total-10px">
    <form action="{{route('difusion.EnviarCertificados')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            @if (isset($datos['nombre']))
            <h3 class="centrar-texto">{{ $datos['nombre'] }}</h3>
            @endif
            <div class="div-borde-redondeado padding-total-10px">
                <h3>Listado de alumnos que pertenecen a este curso</h3>
                <p><b>Formato del listado de alumnos:</b></p>
                <p>La hoja de cálculo debe contener hasta cinco columnas: Nombre, Apellido, DNI, Teléfono y Correo electrónico.</p>
                <p>Deben respetar el mismo orden y no se debe colocar encabezado. No pueden faltar los valores de las
                columnas de nombre, apellido, DNI y correo electrónico, ya que se requieren para realizar el envío.<br>
                El campo de teléfono puede estar en blanco.</p>
                <p>Se recomienda utilizar el mismo archivo con el que se generaron los certificados.</p>

                @if (isset($datos['nombre']))
                    <input type="hidden" name="curso" value="{{ $datos['nombre'] }}">
                @endif

                <input class="boton" type="file" name="contactos" id="listado" required>
            </div>
        </div>
        <br>
        <div class="div-borde-redondeado padding-total-10px">
           <label>
               <input type="checkbox" id="checkbox" name="enviarEmail" value="true">
                   Enviar vía e-mail todos los certificados al terminar de generarlos.
           </label>
           <br>
        </div>
        <div class="centrar-texto margen-superior-20px">
            <button type="submit" class="boton boton-alerta margen-superior-20px">Generar Certificados</button>
        </div>
    </form>
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

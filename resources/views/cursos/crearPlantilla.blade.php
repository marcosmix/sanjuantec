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
    <img src="{{asset('img/modelo.jpg')}}" alt="">
    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre del Curso (5)</label>
        <input type="text" class='form-control' name="nombre" id="nombre" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="texto">Texto del certificado (1)</label>
        <input type="text" class='form-control' name="texto" id="texto" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="duracion">Duracion del curso (2)</label>
        <input type="text" class='form-control' name="duracion" id="duracion" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="fecha">Fecha de emisión (4)</label>
        <input type="text" class='form-control' name="fecha" id="fecha" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="bloque">Bloque (3)</label>
    </div>
    <input type="hidden" name="rutaDeAccion" value="{{ $rutaDeAccion }}">
    <select class="form-select" name="bloque" id="programa">
        @foreach ($programas as $p)
        <option value="{{$p['nombre']}}">{{$p['nombre']}}</option>
        @endforeach
    </select>
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

@include('base')
<!-- Mensajes de error de validación en la subida de archivos que contienen destinatarios. -->
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

<!-- Listado de cursos. -->
<div class="contenedor">
    @foreach ($cursos as $curso)
    <div class="carta">
        <div class="carta-body">
            <h5 class="carta-title">{{ $curso->nombre }}</h5>
            <p class="carta-text">{{ $curso->texto }}</p>
            <p class="carta-text">{{ $curso->bloque }}</p>
            <p class="carta-text">{{ $curso->duracion }}</p>
            <p class="carta-text">{{ $curso->fecha }}</p>
            <p class="carta-text">{{ $curso->bloque }}</p>
        </div>
        <!-- Este formulario oculto envía los datos al controlador para la generación de certificados. -->
        <form action="{{ route('prepararEnvioCertificados') }}" method="POST">
            @csrf
            <input type="hidden" name="datos[nombre]" value="{{ $curso->nombre }}">
            <input type="hidden" name="datos[texto]" value="{{ $curso->texto }}">
            <input type="hidden" name="datos[duracion]" value="{{ $curso->duracion }}">
            <input type="hidden" name="datos[fecha]" value="{{ $curso->fecha }}">
            <input type="hidden" name="datos[bloque]" value="{{ $curso->bloque }}">
            <button type="submit" class="btn btn-success btn-generar">Generar certificados</button>
        </form>
    </div>
    @endforeach
</div>
<div class="centrar-texto">
    <div>
        <a href="{{route('crearPlantilla')}}" class="boton boton-alerta margen-superior-20px">Nueva Plantilla</a>
    </div>
</div>

@include('base')

<div class="contenedor">
    @foreach ($cursos as $curso)
    <div class="carta">
        <div class="carta-body">
            <h5 class="carta-title">{{ $curso->nombre }}</h5>
            <h6 class="carta-subtitle mb-2 text-muted">{{ $curso->programa() }}</h6>
            <p class="carta-text">{{ $curso->texto }}</p>
            <p class="carta-text">{{ $curso->bloque }}</p>
            <p class="carta-text">{{ $curso->duracion }}</p>
            <p class="carta-text">{{ $curso->fecha }}</p>
            <p class="carta-text">{{ $curso->bloque }}</p>
        </div>

        <form action="{{ route('generarCertificados') }}" method="POST">
            @csrf
            <input type="hidden" name="datos[nombre]" value="{{ $curso->nombre }}">
            <input type="hidden" name="datos[texto]" value="{{ $curso->texto }}">
            <input type="hidden" name="datos[duracion]" value="{{ $curso->duracion }}">
            <input type="hidden" name="datos[fecha]" value="{{ $curso->fecha }}">
            <input type="hidden" name="datos[bloque]" value="{{ $curso->bloque }}">
            <input type="hidden" name="datos[programa]" value="{{ $curso->programa() }}">
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

@include('base')
<form class='form-curso' action="{{route('crearPlantilla')}}" method="POST">
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
        <label class="form-label" for="duracion">Duracion del curso (4)</label>
        <input type="text" class='form-control' name="duracion" id="duracion" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="fecha">Fecha de emisión (4)</label>
        <input type="text" class='form-control' name="fecha" id="fecha" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="fecha">Bloque (3)</label>
        <input type="text" class='form-control' name="bloque" id="fecha" required>
    </div>
    <select class="form-select" name="programa_id" id="programa">
        @foreach ($programas as $p)
        <option value="{{$p['id']}}">{{$p['nombre']}}</option>
        @endforeach
    </select>
    <br>
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

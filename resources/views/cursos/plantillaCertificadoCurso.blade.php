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
@if (isset($rutaDeAccion))
    <input type="hidden" name="rutaDeAccion" value="{{ $rutaDeAccion }}">
@endif
<select class="form-select" name="bloque" id="programa">
    @foreach ($programas as $p)
    <option value="{{$p['nombre']}}">{{$p['nombre']}}</option>
    @endforeach
</select>

<style>
    .form-curso{
        width: 60%;
        margin: 30px 20% 0 20%;
    }
</style>
<form class='form-curso' action="{{route('cursos.store')}}" method="POST">
        @csrf
       <img src="{{asset('img/modelo.jpg')}}" alt="">
       
        <div class="mb-3">
            <label class="form-label" for="nombre">Nombre del Curso (5)</label>
            <input type="text" class='form-control' name="nombre" id="nombre">
        </div>
        <div class="mb-3">
            <label class="form-label" for="texto">Texto del certificado (1)</label>
            <input type="text" class='form-control' name="texto" id="texto">
        </div>

        <div class="mb-3">
            <label class="form-label" for="duracion">Duracion del curso (4)</label>
            <input type="text" class='form-control' name="duracion" id="duracion">
        </div>

        <div class="mb-3">
            <label class="form-label" for="fecha">Fecha de emisión (4)</label>
            <input type="text" class='form-control' name="fecha" id="fecha">
        </div>

        <div class="mb-3">
            <label class="form-label" for="fecha">Bloque (3)</label>
            <input type="text" class='form-control' name="bloque" id="fecha">
        </div>

        <select class="form-select" name="programa_id" id="programa">
            @foreach ($programas as $p)
                <option value="{{$p['id']}}">{{$p['nombre']}}</option>
            @endforeach
        </select>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
</form>
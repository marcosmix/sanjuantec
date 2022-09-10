@extends('base')
@section('content')

<div>
    @foreach ($cursos as $curso)
    <div class="card">
        <h2>{{$curso->nombre}}</h2>
        <h3>{{$curso->programa()}}</h3>
        <p>{{$curso->texto}}</p>

        <div>
            <form action="{{route('cursos.destroy',$curso)}}" method="POST">
                @csrf
                @method('DELETE')
                <button>Eliminar</button>
            </form>
            <a href="{{route('generarCertificados',$curso->id)}}">Generar certificados</a>
        </div>
    </div>
    @endforeach
    
</div>
<div>
    <form action="{{route('cursos.store')}}" method="POST">
        @csrf
        <div>
            <label for="nombre">Nombre del Curso</label>
            <input type="text" name="nombre" id="nombre">
        </div>
        <div>
            <label for="texto">Texto del certificado</label>
            <input type="text" name="texto" id="texto">
        </div>
        <select name="programa_id" id="programa">
            @foreach ($programas as $p)
                <option value="{{$p['id']}}">{{$p['nombre']}}</option>
            @endforeach
        </select>
        <button type="submit">Guardar</button>
    </form>
</div>
@endsection
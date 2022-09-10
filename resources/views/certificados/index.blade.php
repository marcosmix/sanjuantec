@extends('base')
@section('content')
    <form action="{{route('generarLectura')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            <input type="hidden" name="nombre" value="{{$curso->nombre}}">
            <input type="hidden" name="texto" value="{{$curso->texto}}">
            <h3>Datos Curso</h3>
            <div>
                <label for="titulo_curso">{{$curso->nombre}}</label>
            </div>
            <div>
                <p>{{$curso->texto}}</p>
            </div>
            <div>
                <label for="listado">Listado de alumnos</label>
                <p>Formato hoja de calculo con tres clumnas: Nombre, Apellido, DNI</p>
                <p>Deben respetar el mismo orden y no se debe colocar encabezados</p>
                <input type="file" name="listado" id="listado">
            </div>
        </div>
        <button type="submit">Generar</button>
    </form>
@endsection
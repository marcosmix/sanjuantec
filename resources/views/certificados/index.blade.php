@extends('base')
@section('content')
    <form action="{{route('generarLectura')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            <input type="hidden" name="id" value="{{$curso->id}}">
            <h3>Generar Certificados</h3>
            <div>
                <h1>Curso {{$curso->nombre}}</h1>
            </div>
            <div>
                <p>{{$curso->texto}}</p>
            </div>
            <div>
                <label for="listado">Listado de alumnos</label>
                <p>Formato de hoja de calculo (Excel) con tres columnas: Nombre, Apellido, DNI, numero telefónico (se debe crear la columna aunque los campos estén vacíos),email</p>
                <p>Deben orden y no se debe colocar encabezados</p>
                <input type="file" name="listado" id="listado">
            </div>
        </div>
        <button type="submit">Generar</button>
    </form>

@endsection
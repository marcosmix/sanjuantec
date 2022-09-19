@extends('base')
@section('content')
    <form action="{{route('importarContactos')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            <h3>Importar contactos</h3>
            <div>
                <label for="listado">Listado de alumnos</label>
                <p>Formato hoja de calculo con tres clumnas: Nombre, Apellido, DNI</p>
                <p>Deben respetar el mismo orden y no se debe colocar encabezados</p>
                <input type="file" name="contactos" id="listado">
            </div>
        </div>
        <button type="submit">Generar</button>
    </form>
@endsection
@extends('base')
@section('content')
    <form action="{{route('generarCertificadoJam')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            <h3>Generar Certificados JAM 2022</h3>
            <div>
                <p>Listado de proyectos</p>
                <input type="file" name="listado" id="listado">
            </div>
        </div>
        <button type="submit">Generar</button>
    </form>

@endsection
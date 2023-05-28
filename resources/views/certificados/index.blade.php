@extends('base')
@section('content')
<h4>Crear Plantillas</h4>
<div>
    <div class="cuadrado cuadrado-1">
        <a href="{{route('plantillas')}}">Crear plantilla de cursos</a>
    </div>
</div>
<br><br>
<h4>Generar Certificados</h4>
<div class="contenedor-cuadrados">
    <div class="cuadrado cuadrado-2">
        <a href="#">Generar<br> Certificados de cursos</a>
    </div>
    <div class="cuadrado cuadrado-3">
        <a href="#">Generar otros certificados</a>
    </div>
    <div class="cuadrado cuadrado-4">
        <a href="#">Generar un certificado de un/a alumno/a</a>
    </div>
</div>
@endsection

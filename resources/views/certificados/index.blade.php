@extends('base')
@section('content')
<h4>Crear Plantillas</h4>
<div>
    <div class="cuadrado cuadrado-1">
        <a href="{{ route('plantillas') }}">Crear plantilla de cursos</a>
    </div>
</div>
<br><br>
<h4>Generar Certificados</h4>
<div class="contenedor-cuadrados">
    <div class="cuadrado cuadrado-2">
        <a href="{{ route('generarCertificadosPorCurso') }}">Generar<br> certificados de cursos</a>
    </div>
    <div class="cuadrado cuadrado-3">
        <a href="{{ route('generarOtrosCertificados') }}">Generar otros certificados</a>
    </div>
    <div class="cuadrado cuadrado-4">
        <a href="{{ route('generarCertificadoPorAlumno') }}">Generar un certificado de un/a alumno/a</a>
    </div>
</div>
<br><br>
<h4>Historial</h4>
<div class="contenedor-cuadrados">
    <div class="cuadrado cuadrado-5">
        <a href=" {{ route('administrarCertificados') }}">Administrar<br> certificados de cursos</a>
    </div>
</div>
@endsection

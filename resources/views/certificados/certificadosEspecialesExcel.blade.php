@extends('base')
@section('content')
<div class="contenedor">
    <h2>Crear Certificados especiales con Excel</h2>
</div>
<form action="{{route('generarCertificadoEspeciales')}}" method="POST" enctype="multipart/form-data">
@csrf

    <div id="crear">
        @include('certificados.crearConExcel')
    </div>
    <div class="content-btn">
        <button class="boton boton-exito">CREAR</button>
        <a href="#inicio" class="boton boton-secundario margen-izquierdo-20px"> VOLVER </a>
    </div>
</form>

<div class="content-btn">
</div>
@endsection

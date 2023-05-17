@extends('base')
@section('content')
<div id="inicio" class="content-btn">
    <a href="#crear"  class="boton boton-exito"> AGREGAR NUEVO CURSO</a>
</div>
<div class="contenedor">
    @foreach ($cursos as $curso)
    @include('cursos.cardCurso')
    @endforeach
</div>
<div id="crear">
    @include('cursos.create')
</div>
<div class="content-btn">
    <a href="#inicio" class="boton boton-secundario"> VOLVER </a>
</div>
@endsection

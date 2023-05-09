@extends('base')
@section('content')
<div class="contenedor contenedor-center-column">
    <div id="inicio" class="content-btn">
        <a href="{{route('cursos.index')}}"  class="btn btn-crear">Certificaciones de cursos </a>
    </div>
    <div id="inicio" class="content-btn">
        <a href="{{route('certificadosEspecialesIndex')}}"  class="btn btn-crear">Certificaciones especiales</a>
    </div>
</div>
@endsection

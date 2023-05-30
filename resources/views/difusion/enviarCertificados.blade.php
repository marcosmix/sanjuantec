@extends('base')
@section('content')
<form class="div-borde-redondeado padding-total-10px" action="{{route('difusion.EnviarCertificados')}}" method="POST" enctype='multipart/form-data'>
        @csrf
    <div>
        <p>Seleccione la plantilla del curso al que desea generar los certificados:</p>
      <div id="inicio">
        <label for="curso">Curso: </label>
        <select name="curso" id="curso">
            @foreach ($cursos as $curso)
                <option value="{{$curso->nombre}}">{{$curso->nombre}}</option>
                @endforeach
        </select>
        <br>
        <label for="crear-certificados">Si el curso no está en el listado, podés crearlo: </label>
            <a href="{{route('plantillas')}}"  class="boton boton-alerta margen-izquierdo-20px" id="crear-certificados">Crear plantilla de curso</a>
      </div>
    </div>
</form>
<br>
@include('difusion.importarContactos')
@endsection

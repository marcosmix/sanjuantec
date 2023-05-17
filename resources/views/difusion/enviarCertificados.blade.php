@extends('base')
@section('content')
<div class="content">

    <form action="{{route('difusion.EnviarCertificados')}}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div>
            <h3>Seleccione el curso</h3>
          <div id="inicio">
            <select name="curso" id="">
                @foreach ($cursos as $curso)
                    <option value="{{$curso->nombre}}">{{$curso->nombre}}</option>
                    @endforeach
                </select>

                    <a href="{{route('cursos.index')}}"  class="boton boton-primario margen-izquierdo-20px">Crear certificación de curso</a>
                </div>

                <div>
                  <h3>Listado de alumnos que pertenecen a ese curso</h3>
                   <p>El listado de alumnos </p>
                   <p>Formato hoja de calculo con tres columnas: Nombre, Apellido, DNI, celular, mail</p>
                   <p>Deben respetar el mismo orden y no se debe colocar encabezado. No pueden faltar los valores de las columnas DNI y email ya que se implementan para realizar el envió, los otros campos pueden estar en blanco.</p>
                   <p>Se recomienda usar el mismo archivo con el que genero los certificados</p>

                    <input class="boton boton-secundario" type="file" name="contactos" id="listado">
                </div>
            </div>
            <br>
            <button class="boton boton-aviso" type="submit">Enviar Mail</button>
        </form>
</div>
@endsection

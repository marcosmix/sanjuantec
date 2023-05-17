@extends('base')
@section('content')
<section>
    <div class="contenedor contenedor-center-column">
        <div class="content-btn">
            <a class="boton boton-primario" href="#">
            Importar contactos
            </a>
        </div>
        <div class="content-btn">
            <a class="boton boton-primario" href="{{ route('difusion.EnviarMensaje') }}">
            Difundir mensaje
            </a>
        </div>
        <div class="content-btn">
            <a class="boton boton-primario" href="{{route('difusion.ImportarAprobados')}}">
            Enviar certificados
            </a>
        </div>
    </div>
</section>
@endsection

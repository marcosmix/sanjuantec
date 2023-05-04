@extends('base')
@section('content')
    <section>
        <a href="#">
            <h3>Importar contactos</h3>
        </a>
        <a href="{{ route('difusion.EnviarMensaje') }}">
            <h3>Difundir mensaje</h3>
        </a>
        <a href="{{route('difusion.ImportarAprobados')}}">
            <h3>Enviar certificados</h3>
        </a>
    </section>
@endsection
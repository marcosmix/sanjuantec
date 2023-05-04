@extends('base')
@section('content')
<div class="content">
    <form action="{{route('difusion.EnviarMensajePOST')}}" method="POST" enctype='multipart/form-data'>
      
        @csrf
        <input type="file" name="contactos" id="listado">
        <button>Enviar</button>
    </form>
</div>
@endsection
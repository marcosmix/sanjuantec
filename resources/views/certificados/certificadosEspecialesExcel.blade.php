@extends('base')
@section('content')
<style>
    .contenedor{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        margin-top:30px;
        flex-wrap: wrap;
    }
    .content-btn{
        display: flex;
        justify-content: space-evenly;
        margin-top: 14px;
    }

    .btn-crear{
        background: #eb8025;
        color: white;
        font-weight: 600;
    }
    

</style>
<div class="contenedor">
    <h2>Crear Certificados especiales con excel</h2>        
</div>
<form action="{{route('generarCertificadoEspeciales')}}" method="POST" enctype="multipart/form-data">
@csrf

    <div id="crear">
        @include('certificados.crearConExcel')
    </div>
    <div class="content-btn">
        <button class="btn btn-crear">CREAR</button>
        <a href="#inicio" class="btn btn-crear"> VOLVER </a>
    </div>
</form>

<div class="content-btn">
</div>
@endsection



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
        justify-content: center;
    }

    .btn-crear{
        background: #eb8025;
        color: white;
        font-weight: 600;
    }
    .contenedor-center-column{
        flex-direction: column;
        height: 154px;
        justify-content: space-around;
        align-items: initial;
    }

</style>

<div class="contenedor contenedor-center-column">
    <div id="inicio" class="content-btn">
        <a href="{{route('cursos.index')}}"  class="btn btn-crear">Ceritifiaciones de cursos </a>
    </div>    
    <div id="inicio" class="content-btn">
        <a href="{{route('certificadosEspecialesIndex')}}"  class="btn btn-crear">Certificaciones especiales</a>
    </div>  
</div>

@endsection
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
    

</style>
 <div id="inicio" class="content-btn">
        <a href="#crear"  class="btn btn-crear"> AGREGAR NUEVO CURSO</a>
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
       <a href="#inicio" class="btn btn-crear"> VOLVER </a>
</div>
@endsection
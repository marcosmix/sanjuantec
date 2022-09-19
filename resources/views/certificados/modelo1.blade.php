<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/certificado/modelo1.css')}}">
    <title>Document</title>
</head>
<body class="a4-horizontal">
<div class="contenedor">

    <div class="titulo-curso">
        <h1>{{$datos['curso']['nombre']}}</h1>
    </div>
    <div class="datos-alumno">
        <div class="datos-alumno__renglon">
            <p >
            Por el presente certificamos que
            </p>
        </div>
        
        <p class="datos-alumno__nombre">
            {{$datos['estudiante']['nombre']}} {{$datos['estudiante']['apellido']}}
        </p>
        <p class="datos-alumno__dni">
            {{$datos['estudiante']['dni']}}
        </p>
    </div>
    <div class="texto-certificado">
        {{$datos['curso']['texto']}} 
        {{$datos['curso']['nombre']}}
        {{$datos['curso']['duracion']}}
        {{$datos['curso']['subprograma']}}
        {{$datos['curso']['fecha']}}
    </div>
    <div class="firmas">
        <img class="firma" src="" >
        <div class="edicion">
            <img class="edicion__logo" src="" >
            <img class="edicion__anio" src="" >
        </div>
        <img class="firma" src="" >
    </div>
    <div class="institucional">
        <img src="" alt="">
    </div>
</div>
</body>
</html>

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
        <img class="firma" src="{{asset('img/f1.jpg')}}" >
        <div class="edicion">
            <img class="edicion__logo" src="{{asset('img/logo_sjt.png')}}" >
            <img class="edicion__anio" src="{{asset('img/2022.png')}}" >
        </div>
        <img class="firma" src="{{asset('img/f2.jpg')}}" >
    </div>
    <div class="institucional">
        <img src="{{asset('img/logos_gobierno.png')}}">
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    {{-- <div style="width: 100%;heigth:100px;"> --}}

    </div>
    <h1>Felicidades  {{$estudiante['nombre']}} ya formas parte de Cursatec</h1>
    <br>
    <br>
    Estas son tus credenciales:  
    <br>
    Usuario:{{$estudiante['user']}}
    <br>
    Contraseña:{{$estudiante['pass']}}
    <p>Ingresa a la plataforma y podrás acceder a los cursos.</p>
    <br>
    <a href="https://cursatec.ar/login/index.php"><H3>COMENZAR MI APRENDIZAJE EN CURSATEC</H3></a>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <h1>Estimada/o:
            @if (is_object($estudiante))
                {{ $estudiante->nombre }}
            @elseif (is_array($estudiante))
                {{ $estudiante['nombre'] }}
            @endif
        </h1>
        {{-- {{ $curso['nombre'] }} --}}
        <br>
        <p>{!! $mensaje !!}</p>
    </body>
</html>

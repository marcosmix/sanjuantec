@extends('base')
@section('content')
<!-- Tabla de administración de certificados.  -->
<div class="centrar-tabla">
    <table class="tabla-certificados">
        <thead>
            <tr>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    N°
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Nombre
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Apellido
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Curso
                </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Estado
                 </th>
                <th>
                    <span class="cursor-apuntador flecha-arriba">&#9650;</span>
                    <span class="cursor-apuntador flecha-abajo">&#9660;</span>
                    Enviado
                </th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Curso</td>
                <td><div class="circulo circulo-verdadero"></div></td>
                <td><div class="circulo circulo-verdadero"></div></td>
                <td><a class="boton-2 boton-ver">Ver</a></td>
                <td><a class="boton-2 boton-enviar">Enviar</a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Curso</td>
                <td><div class="circulo circulo-verdadero"></div></td>
                <td><div class="circulo circulo-verdadero"></div></td>
                <td><a class="boton-2 boton-ver">Ver</a></td>
                <td><a class="boton-2 boton-enviar">Enviar</a></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Curso</td>
                <td><div class="circulo circulo-falso"></div></td>
                <td><div class="circulo circulo-falso"></div></td>
                <td><a class="boton-2 boton-ver">Ver</a></td>
                <td><a class="boton-2 boton-enviar">Enviar</a></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Curso</td>
                <td><div class="circulo circulo-verdadero"></div></td>
                <td><div class="circulo circulo-verdadero"></div></td>
                <td><a class="boton-2 boton-ver">Ver</a></td>
                <td><a class="boton-2 boton-enviar">Enviar</a></td>
            </tr>
        </tbody>
        </tr>
    </table>
</div>
<div class="centrar-texto">
    <button type="submit" class="boton boton-alerta margen-superior-60px">Enviar todos los certificados</button>
</div>
  @endsection

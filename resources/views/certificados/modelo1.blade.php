<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Certificados</title>
        <style>@font-face {
            font-family: Brokman;
            src: url('/fonts/Brokman-Bold.ttf');
        }

        @font-face {
            font-family: Brokman-BoldItalic;
            src: url('/fonts/Brokman-BoldItalic.otf');
        }

        @font-face {
            font-family: Brokman-ExtraBold;
            src: url('/fonts/Brokman-Extrabold.otf');
        }

        @font-face {
            font-family: calibri;
            src: url('/fonts/calibri.ttf');
        }

        @font-face {
            font-family: calibri-b;
            src: url('/fonts/calibri-b.ttf');
        }

        @font-face {
            font-family: GreatVibes-Regular;
            src: url('/fonts/GreatVibes-Regular.ttf');
        }

        </style><style>* {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 295mm;
            height: 210mm;
            background-image: url({{ base64ConvertirImagen(public_path('img/bg.jpg')) }});
            background-repeat: no-repeat;
            background-size: contain;
            display: flex;
        }

        .titular {
            display: flex;
            font-family: calibri;
            font-size: 2.2em;
            color: #9c3234;
            text-align: center;
            width: 70%;
            padding: 1cm 40mm 0 40mm;
            line-height: 0.9;
        }

        .prefijo {
            display: flex;
            padding: 0.5cm 40mm 0 40mm;
            font-size: 1.6em;
            font-family: calibri;
        }

        .datosAlumno {
            display: flex;
            /* flex-direction: column; */
            align-items: center;
            justify-content: center;
            width: 70%;
            padding: 1cm 0mm 0 0mm;
            border-bottom: 1px goldenrod solid;
            margin-left: 4.4cm;
            text-align: center;
        }

        .datosAlumno__nombre {
            display: inline;
            font-size: 2.4em;
            font-family: GreatVibes-Regular;
            padding-left: 10mm;
        }

        .datosAlumno__dni {
            padding-left: 10mm;
            font-family: calibri;
            font-size: 1.4em;
        }

        .contenedor-texto {
            width: 21cm;
            /* padding: 0cm 0mm 0 90mm;  */
            margin-left: 4.4cm;
            font-size: 1.2em;
            font-family: calibri;
        }

        .logosTec {
            /* padding-top:1cm; */
            width: 20cm;
            margin-left: 4.4cm;
        }

        .logosTec__firmaI {
            height: 3cm;
            float: left;
        }

        .logosTec__firmaD {
            height: 3cm;
            float: right;
        }

        .edicion {
            height: 2cm;
            position: relative;
            top: 7mm;
            left: 30mm;
        }

        .logossj {
            width: 21cm;
            margin-left: 6.4cm;
        }

        .logos {
            /* height: 15mm; */
            width: 100%;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <p class="titular" >Curso de {{$datos['curso']['nombre']}}</p>
            <p class="prefijo" >Por el presente certificamos que</p>
            <p class="datosAlumno">
                <span class="datosAlumno__nombre">{{$datos['estudiante']['nombre']}} {{$datos['estudiante']['apellido']}}</span>
                <span class="datosAlumno__dni"> DNI {{$datos['estudiante']['dni']}}</span>
            </p>
            <section class="contenedor-texto">
                <p>{{$datos['curso']['texto']}}"{{$datos['curso']['nombre']}}", con una duración de {{$datos['curso']['duracion']}}, perteneciente <span id="nombre_subprograma">{{$datos['curso']['bloque']}}</span>, organizado por San Juan Tec 2022.</p>
                <p>San Juan a los {{$datos['curso']['fecha']}}.</p>
            </section>
            <div class="logosTec">
                <br><br>
                <img class="logosTec__firmaI" src="{{ base64ConvertirImagen(public_path('img/ariel_lucero.jpg')) }}" alt="">
                <img class="edicion" src="{{ base64ConvertirImagen(public_path('img/20222.jpg')) }}" alt="">
                <img class="logosTec__firmaD" src="{{ base64ConvertirImagen(public_path('img/daniel_gimeno.jpg')) }}" alt="">
            </div>
            <div class="logossj">
                <br><br><br><br><br><br><br><br>
                 <img class="logos" src="{{ base64ConvertirImagen(public_path('img/logos-sj.png')) }}" alt="">
            </div>
        </div>
    </body>
</html>

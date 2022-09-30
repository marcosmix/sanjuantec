<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificados</title>

    <link rel="stylesheet" href="{{asset('css/certificad/mod_1.css')}}style.css">

    <style>
        @font-face {
            font-family: Brokman-Medium;
            src: url('../fonts/Brokman-Medium.otf');
        }
        @font-face {
            font-family: Brokman-BoldItalic;
            src: url('../fonts/Brokman-BoldItalic.otf');
        }
        @font-face {
            font-family: Brokman-ExtraBold;
            src: url('../fonts/Brokman-Extrabold.otf');
        }
        @font-face {
            font-family: calibri;
            src: url('../fonts/calibri.ttf');
        }
        @font-face {
            font-family: GreatVibes-Regular;
            src: url('../fonts/GreatVibes-Regular.ttf');
        }
    </style>

    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .container {
            width: 1080px;
            height: 888px;
            padding-top: 70px;
            background-image: url('./img/bg.jpg');
            background-repeat: no-repeat;
        }
        h1 {
            font-family: Brokman-Medium;
            color: #9c3234;
            font-size: 35px;
            padding: 0 0 20px 120px;
        }
        h1 span {
            font-family: Brokman-Medium;
            color: #9c3234;
            font-size: 35px !important;
        }
        p,
        h2,
        span {
            font-family: calibri;
            font-size: 26px !important;
            color: #3a3a3a;
            line-height: 1.8;
        }
        p {
            width: 850px;
            margin-left: 200px;
            padding: 0 20px;
        }
        .datos {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }
        .datos::after {
            content: '';
            width: 100%;
            height: 2px;
            background: #e5b465;
            position: absolute;
            bottom: 30px;
            left: 0;
            opacity: 0.6;
        }
        #nombre_alumno {
            display: inline-block;
            font-family: GreatVibes-Regular;
            font-size: 60px !important;
            text-align: left !important;
            margin: 0 auto;
        }
        .logos_tec {
            width: 850px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logos_tec img {
            width: 140px;
        }
        .logos_tec img:nth-child(1) {
            margin-top: 30px;
        }
        .logos_column {
            width: 200px;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .logos_column img {
            width: 100%;
        }
        .logossj {
            margin-top: 40px;
            text-align: center;
        }
        .logossj img {
            height: 49px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Curso de <span id="nombre_curso">-- Nombre Curso --</span></h1>

        <p>Por el presente certificamos que</p>

        <p class="datos">
            <span id="nombre_alumno">-- Aguilera, Gloria Isabel --</span>

            DNI <span id="dni_alumno">-- 16.127.164 --</span>
        </p>

        <p>ha participado del curso teórico-prático "<span id="nombre_curso2">-- Introducción al diseño para el Marketing Digital --</span>", con una duración de 3 meses y medio, perteneciente al subprograma <span id="nombre_subprograma">-- Nombre subprograma --</span>, organizado por San Juan Tec 2022.</p>
        <p>San Juan a los <span id="fecha_emisión">-- 25 días de Abril de 2022 --</span>.</p>


        <div class="logos_tec">
            <img src="img/ariel_lucero.jpg" alt="">

            <div class="logos_column">
                <img src="img/sjtec.jpg" alt="">
                <img src="img/2022.jpg" alt="">
            </div>

            <img src="img/daniel_gimeno.jpg" alt="">
        </div>

        <div class="logossj">
            <img src="img/logos-sj.jpg" alt="">
        </div>
    </div>
    
</body>
</html>
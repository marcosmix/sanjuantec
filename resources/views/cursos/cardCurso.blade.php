
<style>
  .card{
    
        width: 80%;
    height: 114px;
    display: flex;
    flex-direction: row;
    padding: 5px 18px;

  }
  .card-body{
   
    overflow-y: scroll;
    width: 100%;
    height: 114px;
  }

  .card-body {
 overflow: auto; /*Graceful degradation para Firefox*/
 overflow: overlay;
}

/*Webkit(Chrome, Android browser, Safari, Edge...)*/
.card-body::-webkit-scrollbar {
 display: none;
}
.card-body:hover::-webkit-scrollbar {
 display: initial;
}
.card-body::-webkit-scrollbar-thumb {
background-color: #09C;
}

  .btn-generar{
        width: 136px;
    height: 69px;
    margin: 18px 39px;
  }
</style>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{$curso->nombre}}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$curso->programa()}}</h6>
    <p class="card-text">{{$curso->texto}}</p>
     <p class="card-text">{{$curso->bloque}}</p>
     <p class="card-text">{{$curso->duracion}}</p>
     <p class="card-text">{{$curso->fecha}}</p>
     <p class="card-text">{{$curso->bloque}}</p>

    </div>
     <a href="{{route('generarCertificados',$curso->id)}}" class="btn btn-success btn-generar">Generar certificados</a>
</div>


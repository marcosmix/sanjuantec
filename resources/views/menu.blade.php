<style>
  nav{
    display: flex;
    justify-content: stretch;
    margin: 5px 0;
    padding: 10px 9px;
    background-color: #a33434;
    color: white;
    height: 57px;
    align-items: center;
    position: relative
  }
  .opcion{
    margin-left: 18px;
    padding: 15px 15px;
    border-radius: 15px;
    height: 30px;
 
  }
  a:visited, a{
    text-decoration: none;

  }
  .opcion:visited{
      color: white;
  }

  .opcion:hover{
   background-color: black;
  }
  .opcion img{
    height: 28px;
  }
</style>
<nav>
  <div class="container-fluid">
    <a class="opcion" href="{{route('curos-inicio')}}">
      <img src="{{asset('img/Course.webp')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Crear Certificaciones
    </a>
  </div>
  <div class="container-fluid">
    <a class="opcion" href="{{route('difusion.index')}}">
      <img src="{{asset('img/mail.png')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Difusion
    </a>
  </div>
</nav>

  
<nav>
  <div>
    <a class="opcion" href="{{route('cursosInicio')}}">
      <img src="{{asset('img/Course.webp')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Crear Certificaciones
    </a>
  </div>
  <div>
    <a class="opcion" href="{{route('difusion.index')}}">
      <img src="{{asset('img/mail.png')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Difusión
    </a>
  </div>
  <div>
    <a class="opcion" href="{{route('register')}}">
      <img src="{{asset('img/icons8-add-user-male-96.png')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Registrar usuario
    </a>
  </div>
  <div>
    <form class="" method="POST" action="{{ route('logout') }}">
        @csrf
        <a class="cursor-apuntador opcion" :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
            <img src="{{asset('img/icons8-exit-96.png')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
             {{ __('Salir') }}
        </a>
    </form>
  </div>
</nav>


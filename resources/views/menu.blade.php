<nav>
  <div>
    <a class="opcion" href="{{route('cursosInicio')}}">
      <img src="{{asset('img/Course.webp')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Crear Certificaciones
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


@include('base')

@if((isset($mensaje)) || (!empty($mensaje)))
    <p class="centrar-texto">{{ $mensaje }}</p>
@endif

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">

            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" />

                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Dirección de email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Determinar Rol -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-bold mb-2">{{ __('Seleccionar rol') }}</label>
                <select name="role" id="role" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="usuario">Usuario</option>
                    <option value="secretario">Secretario</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya se encuentra registrado?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Registrar') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@include('footer')
<script>
/**
 * Esta función elimina la colleción HTML bajo la clase 'content-section'. La misma no es requerida en esta específica vista.
 * @author Leandro Brizuela
 */
function eliminarSeccion() {
    var elements = document.getElementsByClassName('content-section');
    while (elements.length > 0) {
        elements[0].remove();
    }
}

eliminarSeccion();
</script>

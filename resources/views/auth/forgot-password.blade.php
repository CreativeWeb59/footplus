<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <h1 class="shawdowed" >Footplus</h1>
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 label">
            {{ __('Vous avez oublié votre mot de passe ? Inscrivez votre adresse email ci-dessous et cliquez sur le bouton,
            nous vous enverrons un lien pour le réinitialiser et vous pourrez le changer afin de vous connecter.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Adresse email')" class="label" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Renvoyer le mot de passe') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

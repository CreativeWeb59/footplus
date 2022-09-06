<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Footplus</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/097058085d.js" crossorigin="anonymous"></script>
</head>

<body>
    <section class="flex flex-col justify-start bg-[url('../images/fonds04.jpg')] bg-cover bg-no-repeat bg-center">
        @if (Route::has('login'))
        <header class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-white dark:text-white underline">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-sm text-white dark:text-white underline">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-white dark:text-white underline">Register</a>
            @endif
            @endauth
        </header>
        <div class="w-96 my-auto mx-auto">
            <h1 class="shawdowed" >Footplus</h1>
            <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="{{ route('login') }} ">
                @csrf
                <!-- Email Address -->
                <div>
                    <x-label for="email" :value="__('Email')"  />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Mot de passe')" />

                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
                <!-- Remember Me -->
                <div class="block my-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600 label">{{ __('Se souvenir de moi') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end my-4">
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 label hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié') }}
                    </a>
                    @endif

                    <x-button class="ml-3">
                        {{ __('Se connecter') }}
                    </x-button>
                </div>
            </form>
        </div>
        @endif
    </section>
</body>
</html>
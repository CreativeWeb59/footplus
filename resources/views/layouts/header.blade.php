    <div class="w-1/4 h-20 pl-16 flex content-center items-center justify-center">
        <img class="h-10 w-auto" src="{{asset('images/logo_foot.png')}}" alt="logo" width="180" />
    </div>
    <h1 class="h-20 text-white text-5xl font-bold text-center w-1/2 flex content-center items-center justify-center">
        Statistiques du championnat de foot</h1>
    @guest
    {{-- Affichage du login/connexion --}}
    @include('partials.navlog')
    @else
    @if (auth()->user()->role_id==2)
    <div class="w-full">
        <a class="text-white" href="/dashboard">Administration</a>
    </div>
    {{-- Affichage du login/connexion --}}
    @include('partials.navlog')
    @else
    @include('partials.navlog')
    @endif
    @endguest



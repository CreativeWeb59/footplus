<div class="w-1/4 h-20 flex justify-end items-center content-center pr-16">
    @guest
            <div class="mx-2">
                <a href="{{ route('login') }}" class="link1" title="Se connecter">
                    <i class="fas fa-user-alt text-xl pt-2 mr-1"></i>
                </a>
            </div>
            <div class="mx-2 relative">
                <a href="{{ route('register') }}" class="link1" title="S'inscrire">
                    <i class="fas fa-user-edit text-xl pt-2 mr-1"></i>
                </a>
            </div>    
        @else
                <a href="{{ route('/') }}" class="link1 mr-12" title="Mon compte">Bonjour {{ auth()->user()->name }}</a>    
                <a href="{{ route('logout') }}" class="link1" title="Se déconnecter" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i class="fas fa-user-slash text-xl pt-2 mr-1"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
        @endguest
    
    </div>
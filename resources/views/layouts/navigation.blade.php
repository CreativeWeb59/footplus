<nav x-data="{ open: false }" class="border-b border-red-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center h-16">
            <div class="flex w-full">

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-36 sm:flex w-full justify-center"> --}}
                    <div class="hidden space-x-24 sm:flex w-full justify-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Accueil') }}
                    </x-nav-link>
                    <x-nav-link :href="route('listematchs.index')" :active="request()->routeIs('listematchs.index')">
                        {{ __('Calendrier / Résultat') }}
                    </x-nav-link>
                    <x-nav-link :href="route('StatistiquesController.index')" :active="request()->routeIs('StatistiquesController.index')">
                        {{ __('Les matchs') }}
                    </x-nav-link>
                    <x-nav-link :href="route('statsJourneesController.index')" :active="request()->routeIs('statsJourneesController.index')">
                        {{ __('Les journées') }}
                    </x-nav-link>
                    <x-nav-link :href="route('classement.index')" :active="request()->routeIs('classement.index')">
                        {{ __('Classement') }}
                    </x-nav-link>
                    <x-nav-link :href="route('JourneesController.index')" :active="request()->routeIs('JourneesController.index')">
                        {{ __('Paramétrage') }}
                    </x-nav-link>
                </div>
            </div>


            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

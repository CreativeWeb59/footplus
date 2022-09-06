<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 w-full h-screen text-slate-800 italic">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-slate-800">Dernières mises à jours</h1>
                    <p class="my-8 leading-loose">
                        <i class="fas fa-futbol mr-2"></i>Equipes montées en ligue 1 : Ajaccio, Auxerre et Toulouse<br>
                        <i class="fas fa-futbol mr-2"></i>Equipes descendues en ligue 2 : Bordeaux, Saint-Etienne et Metz<br><br>
                        <i class="fas fa-futbol mr-2"></i>Equipes montées en ligue 2 : Laval et Annecy<br>
                        <i class="fas fa-futbol mr-2"></i>Equipes descendues en nationale : Nancy et Dunkerque<br><br>
                        <i class="fas fa-futbol mr-2"></i>Simplification des menus, <br>
                        <i class="fas fa-futbol mr-2"></i>Interface plus rapide : pas de délai d'attente entre chaque reqûete, <br>
                        <i class="fas fa-futbol mr-2"></i>Mise à jour du score dans "Calendrier/résultat" directement à partir de chaque match,<br>
                        <i class="fas fa-futbol mr-2"></i>Mise à jour de la même manière pour les commentaires de chaque match,<br>
                        <i class="fas fa-futbol mr-2"></i>Ajout gestion de la ligue 2,<br>
                        <i class="fas fa-futbol mr-2"></i>Statistiques sur 2 années avec gestion du changement de division. <br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

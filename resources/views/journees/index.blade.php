<x-app-layout>
    <x-slot name="header">
        <h1 class="text-center text-4xl">Calendrier et résultats</h1>
    </x-slot>
  <section class="w-full flex-col p-4">
    <!--Formulaire de lecture des journées de championnat-->
    <h1 class="text-white mt-8">Saisie des journées de championnat</h2>

    <div class="h-3/5 bg-gradient-to-r from-red-800 to-red-400 w-3/5 mt-8 border border-solid border-black mx-auto">
        <form method="post" action="{{route('JourneesController.store')}}" class="p-8 flex flex-wrap justify-center items-center content-center font-bold">
            @csrf
            @method('PUT')
            <span class="w-2/5 my-4 p-0 text-left">
                Saison : <label for="seasons_id"></label>
                <select name="seasons_id" id="seasons_id">
                    @foreach ($lSaisons as $lSaison)
                            @if ($lSaison['id'] == $sSelected)
                                <option value={{ $lSaison['id']}}  selected>{{ $lSaison['nom']}} :</option>
                            @else
                            <option value={{ $lSaison['id']}}>{{ $lSaison['nom']}} :</option>
                            @endif
                    @endforeach
                </select>
            </span>
            <span class="w-1/2 my-4 p-0 text-center">
                Championnat : <label for="championnats_id"></label>
                <select name="championnats_id" id="championnats_id" required>
                    @foreach ($lChampionnats as $lChampionnat)
                        @if ($lChampionnat['id'] == $cSelected)
                            <option value={{ $lChampionnat['id']}}  selected>{{ $lChampionnat['nom']}} :</option>
                        @else
                        <option value={{ $lChampionnat['id']}}>{{ $lChampionnat['nom']}} :</option>
                        @endif
                    @endforeach
                </select>
            </span>
            <span class="w-full my-4 p-0 text-center">
                Numéro de journée : <label for="id_journees"></label>
                <select name="num_journee" id="id_journees" required>
                    <!--en php compter le nombre d'équipe en ligue 1 multi par 2 -2 -->
                    {{-- variable nom journée $numjournee --}}
                  
                    @for ($i = 1; $i <= $renvoi['nbJournees']; $i++)
                        @if ($i == $renvoi['num_journee'])
                            <option value="{{ $i }} "selected> {{ $i }}</option>
                        @else
                            <option value="{{ $i }} "> {{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </span>
            <span class="w-2/5 my-4 p-0 text-left">Date du match : <label for="date_match"></label>
                <input type ="date" name="date_match" size="80"
                    @isset($renvoi['date_match'])
                        value="{{ ($renvoi['date_match']) }}"
                    @endisset
                    id="date_match" required>
            </span>
            <span class="w-2/5 my-4 p-0 text-left">Heure du match : 
                <label for="heure_match"></label>
                <input type ="time" name="heure_match" size="80" 
                    @isset($renvoi['heure_match'])
                        value="{{ ($renvoi['heure_match']) }}"
                    @endisset
                    id="heure_match" required>
            </span>
            <span class="w-2/5 my-4 p-0 text-left">
                <select name="equipes1_id" id="equipe1" required>
                    {{-- recuperation du nom des equipes dans la table, array : $equipe1[] --}}
                    @foreach ($equipes as $equipe)
                    {{-- @foreach ($equipes->sortBy('id', 'desc') as $equipe) --}}
                        <option value={{ $equipe->equipe_id }}>{{ $equipe->equipe->nom }}</option>
                    @endforeach
                </select>
                <label for="buts_equipe1"> : </label>
                    <input type="number" id="buts_equipe1" name="buts_equipe1" value=-1 min=-1 max=20 placeholder="-1" size="3" title="Laissez à -1 si le match n'a pas encore été joué">
            </span>
            <span class="w-2/5 my-4 p-0 text-left"><label for="equipes2_id"></label>
                <select name="equipes2_id" id="equipe2" required>
                    {{-- // recuperation du nom des equipes dans la table, array : $equipe1[] --}}
                    @foreach ($equipes as $equipe)
                        <option value={{ $equipe->equipe_id }}>{{ $equipe->equipe->nom }}</option>
                    @endforeach
                </select>
                <label for="buts_equipe2"> : </label>
                <input type="number" id="buts_equipe2" name="buts_equipe2" value=-1 min="-1" max="20" placeholder="-1" size="3" title="Laissez à -1 si le match n'a pas encore été joué">
            </span>
            <span class="w-full mx-2 my-4 p-0 text-left">
                <label for="commentaire">Commentaire sur le match :</label>
            </span>
            <span class="w-full h-1/6 text-center mx-2 p-0">
                <textarea id="commentaire" name="commentaire" class="w-full h-28 resize-none"></textarea>
            </span>
            <span class="w-full h-1/6 text-center my-4 flex items-center content-center justify-evenly">
                <button class="w-2/5 bg-red-600 text-white shadow" type="reset">Annuler</button>
                <button class="w-2/5 bg-red-600 text-white shadow" type="submit" name="envoi">Valider</button>
                <label title="Cocher pour saisir les suivants à l'identique"><input class="w-5 h-5 mt-1 bg-blue-60" type="checkbox" id="identique" name="identique" value="1" checked></label>
            </span>
        </form>
    </div>
  </section>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-center text-4xl">Les résultats des matchs</h1>
    </x-slot>

    <h2 class="mt-8 text-center">Classement en cours</h2>
    <table class="bg-white w-11/12 mt-8 border border-solid border-black text-xs font-bold text-center absolute left-1/2 -translate-x-1/2">
    <thead>
        <tr>
            <td class="w-16 border border-solid border-black">Place</td>
            <td class="w-40 border border-solid border-black">Equipe</td>
            <td class="w-8 border border-solid border-black">pts</td>
            <td class="w-8 border border-solid border-black">J.</td>
            <td class="w-8 border border-solid border-black">G.</td>
            <td class="w-8 border border-solid border-black">N.</td>
            <td class="w-8 border border-solid border-black">P.</td>
            <td class="w-8 border border-solid border-black">p.</td>
            <td class="w-8 border border-solid border-black">c.</td>
            <td class="w-8 border border-solid border-black">+/-</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($classements as $classement)
            <tr class="border border-solid border-blue-500">
                <td class="border border-solid border-black">{{ $classement['classement_en_cours'] }}</td>
                <td class="border border-solid border-black text-left pl-4">{{ $classement['nom'] }}</td>
                <td class="border border-solid border-black">{{ $classement['points'] }}</td>
                <td class="border border-solid border-black">{{ $classement['nb_match_joue'] }}</td>
                <td class="border border-solid border-black">{{ $classement['nb_match_gagne'] }}</td>
                <td class="border border-solid border-black">{{ $classement['nb_match_null'] }}</td>
                <td class="border border-solid border-black">{{ $classement['nb_match_perdu'] }}</td>
                <td class="border border-solid border-black">{{ $classement['but_marque'] }}</td>
                <td class="border border-solid border-black">{{ $classement['but_encaisse'] }}</td>
                <td class="border border-solid border-black">{{ $classement['difference_but'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="relative">
    <move-div></move-div>
</div>
</x-app-layout>
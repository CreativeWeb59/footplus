<x-app-layout>
    <x-slot name="header">
        <h1 class="text-blue-600 text-center text-4xl">Liste des équipes</h1>
    </x-slot>
    <div class="flex w-full">
        <section class="w-full flex flex-col justify-center">
            <table class="bg-white w-3/4 mt-8 border border-solid border-black text-xs font-bold text-center mx-auto">
                <thead>
                    <tr>
                        <td class="border border-solid border-black">
                            <h2 class="text-2xl">id</h2>
                        </td>
                        <td class="border border-solid border-black">
                            <h2 class="text-2xl">Nom</h2>
                        </td>
                        <td class="border border-solid border-black">
                            <h2 class="text-2xl">Championnat</h2>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipes as $equipe)
                    <tr class="border border-solid border-blue-500">
                        <td class="border border-solid border-black">{{ $equipe->id}}</td>
                        <td class="border border-solid border-black text-left">{{ $equipe->nom }}</td>
                        <td class="border border-solid border-black">{{ $equipe->championnats_id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Classement --}}
            <table class="bg-white w-3/4 mt-8 border border-solid border-black text-xs font-bold text-center mx-auto">
            <thead>
                <tr>
                    <td class="border border-solid border-black">
                        <h2 class="text-2xl">id</h2>
                    </td>
                    <td class="border border-solid border-black">
                        <h2 class="text-2xl">Nom</h2>
                    </td>
                    <td class="border border-solid border-black">
                        <h2 class="text-2xl">Championnat</h2>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($classements as $classement)
                <tr class="border border-solid border-blue-500">
                    <td class="border border-solid border-black">{{ $classement['nb_match_joue']}}</td>
                    <td class="border border-solid border-black">{{ $classement['points']}}</td>
                    <td class="border border-solid border-black">{{ $classement['nom']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </section>

    </div>
</x-app-layout>
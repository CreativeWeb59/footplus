<x-app-layout>
    <x-slot name="header">
        <h1 class="text-blue-600 text-center text-4xl">Liste des équipes</h1>
    </x-slot>
    <div class="flex w-full">
        <aside class="w-1/6 flex flex-col items-center content-center">
            {{-- @include('classements.index') --}}
            <vue-classement></vue-classement>
            {{-- <vue-classement :classement-id="10"></vue-classement> --}}
        </aside>
        <section class="w-5/6 relative">
            <table
                class="bg-white w-3/4 mt-8 border border-solid border-black text-xs font-bold text-center left-1/2 absolute -translate-x-1/2">
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
                        <td class="border border-solid border-black">
                            <h2 class="text-2xl">Saison</h2>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipes as $equipe)
                    <tr class="border border-solid border-blue-500">
                        <td class="border border-solid border-black">{{ $equipe->id}}</td>
                        <td class="border border-solid border-black text-left">{{ $equipe->equipe->nom }}</td>
                        <td class="border border-solid border-black">{{ $equipe->championnat_id }}</td>
                        <td class="border border-solid border-black">{{ $equipe->season_id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
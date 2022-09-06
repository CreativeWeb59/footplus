<x-app-layout>
    <x-slot name="header">
        <h1 class="text-center text-4xl">Les résultats des matchs</h1>
    </x-slot>
    <div class="flex w-full h-full bg-white">
        <aside class="w-1/6 flex flex-col items-center content-center bg-blue-400">
            {{-- @include('classements.index') --}}
            <vue-classement></vue-classement>
            {{-- <vue-classement :classement-id="10"></vue-classement> --}}
        </aside>
        <div class="w-5/6">
            <div class="w-full my-8">
                <h1 class="text-slate-800">Statistiques sur les journées de championnat</h1>
            </div>
            <div class="w-full flex">
                {{-- Stats équipe 1 --}}
                <div class="w-1/2 bg-white shadow-2xl">
                    <h2 class="text-black">Equipe 1</h2>
                    <vue-Journees></vue-Journees>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
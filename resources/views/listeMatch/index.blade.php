<x-app-layout>
    <x-slot name="header">
        <h1 class="text-center text-4xl">Calendrier et résultats</h1>
    </x-slot>
  <section class="w-full flex-col p-4">
    <!--Formulaire de lecture des journées de championnat-->
    <vue-liste-match></vue-liste-match>
  </section>
</x-app-layout>
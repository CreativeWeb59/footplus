<template>
    <h2 class="mt-8 text-center">Classement en cours</h2>
      <form @submit.prevent="submit" class="mt-8 w-full p-2">
        <div class="w-full my-2">
          <label for="championnat_id">Championnat : </label>
          <select name="championnat_id" id="championnat_id" v-model="fields.championnats_id" @change="submit">
            <option v-for="championnat in championnats" v-bind:key="championnat.id" :value="championnat.id">{{ championnat.nom }}
            </option>
          </select>
        </div>
        <div class="my-2 flex justify-between align-middle items-center">
          <label class="pl-1" for="season_id">Saison : </label>
          <select name="season_id" id="season_id" v-model="fields.seasons_id" @change="submit">
              <option v-for="season in seasons" v-bind:key="season.id" :value="season.id">{{ season.nom }}
              </option>
          </select>
        </div>
    </form>
    <table class="bg-white w-11/12 my-8 border border-solid border-black text-xs font-bold text-center">
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
            <tr v-for="classement in classements" v-bind:key="classement.id"
                class="border border-solid border-blue-500">
                <td class="border border-solid border-black">{{ classement.classement_en_cours }}</td>
                <td class="border border-solid border-black text-left pl-4">{{ classement.nom }}</td>
                <td class="border border-solid border-black">{{ classement.points }}</td>
                <td class="border border-solid border-black">{{ classement.nb_match_joue }}</td>
                <td class="border border-solid border-black">{{ classement.nb_match_gagne }}</td>
                <td class="border border-solid border-black">{{ classement.nb_match_null }}</td>
                <td class="border border-solid border-black">{{ classement.nb_match_perdu }}</td>
                <td class="border border-solid border-black">{{ classement.but_marque }}</td>
                <td class="border border-solid border-black">{{ classement.but_encaisse }}</td>
                <td class="border border-solid border-black">{{ classement.difference_but }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>

import axios from 'axios'

export default {
  data () {
    return {
      classements: [],
      seasons: [],
      championnats: [],
      fields: { seasons_id: 3, championnats_id: 1 }
    }
  },
  mounted () {
    this.getClassements()
    this.getSeason()
    this.getChampionnats()
  },

  methods: {
    getClassements () {
      axios.get('/api/classements')
        .then((response) => (this.classements = response.data))
        .catch(err => console.log(err))
    },

    getSeason () {
      axios.get('/api/seasons')
        .then((response) => (this.seasons = response.data))
        .catch(err => console.log(err))
    },

    getChampionnats () {
      axios.get('/api/championnats')
        .then((response) => (this.championnats = response.data))
        .catch(err => console.log(err))
    },

    submit () {
      axios.post('/api/classements', this.fields)
        .then((response) => (this.classements = response.data))
        .catch(err => console.log(err))
    }
  }
}
</script>

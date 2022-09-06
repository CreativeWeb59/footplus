<template>
  <div>
    <h2 class="mt-8 text-center">Statistiques</h2>
      <form @submit.prevent="submit" class="mt-8 w-full p-2">
        <div class="w-full my-2 flex justify-center space-x-4">
          <div class="w-36 my-2 flex justify-end"><label for="championnat_id">Championnat : </label></div>
          <select class="w-1/4" name="championnat_id" id="championnat_id" v-model="fields.championnats_id" @change="submit">
            <option v-for="championnat in championnats" v-bind:key="championnat.id" :value="championnat.id">{{ championnat.nom }}
            </option>
          </select>
          <div class="w-36"></div>
        </div>
        <div class="w-full my-2 flex justify-center space-x-4">
          <div class="w-36 my-2 flex justify-end"><label class="pl-1" for="season_id">Saison : </label></div>
          <select class="w-1/4" name="season_id" id="season_id" v-model="fields.seasons_id" @change="submit">
              <option v-for="season in seasons" v-bind:key="season.id" :value="season.id">{{ season.nom }}
              </option>
          </select>
          <div class="w-36"></div>
        </div>
        <div class="w-full my-2 flex justify-center space-x-4">
          <div class="w-36 my-2 flex justify-end"><label class="pl-1" for="season_id">Equipe : </label></div>
          <select class="w-1/4" name="equipe_id" id="equipe_id" v-model="fields.equipes_id" @change="submit">
              <option v-for="equipe in equipes" v-bind:key="equipe.id" :value="equipe.id">{{ equipe.equipe.nom }}
                <input type="text" v-bind="fields.lEquipes_id" :value="equipe.equipes_id">
              </option>
          </select>
          <div class="w-36"></div>
        </div>
    </form>
    <vue-statistiques :equipesId="fields.lEquipes_id"></vue-statistiques>
    </div>
</template>

<script>

import axios from 'axios'

export default {
  data () {
    return {
      seasons: [],
      championnats: [],
      equipes: [],
      fields: { seasons_id: 3, championnats_id: 1, equipes_id: 49, lEquipes_id: 1 }
    }
  },
  mounted () {
    this.getSeason()
    this.getChampionnats()
    this.getEquipes()
  },

  methods: {
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
    getEquipes () {
      axios.get('/api/historiqueEquipes')
        .then((response) => (this.equipes = response.data))
        .catch(err => console.log(err))
    },
    submit () {
      axios.post('/api/historiqueEquipes', this.fields)
        .then((response) => (this.equipes = response.data))
        .catch(err => console.log(err))
    }
  }
}
</script>

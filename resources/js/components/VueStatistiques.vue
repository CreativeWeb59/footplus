<template>
  <div class="bg-white">
    <h2 class="text-center">Statistiques</h2>
      <form @submit.prevent="submit" class="w-full p-2">
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
          <select class="w-1/4" name="equipesId" id="equipesId" v-model="fields.equipesId" @change="submit">
              <option v-for="equipe in equipes" v-bind:key="equipe.equipe.nom" :value="equipe.equipe_id">{{ equipe.equipe.nom }}
              </option>
          </select>
          <div class="w-36"></div>
        </div>
        <div class="w-full my-2 flex justify-center space-x-4">
          <div class="w-36 my-2 flex justify-end"><label class="pl-1" for="cxResultats_id">Résultats : </label></div>
            <select class="w-1/4 h-12" name="cxResultats_id" id="cxResultats_id" v-model="fields.cxResultats_id" @change="submitResultat">
                <option v-for="cxResultat in cxResultats" v-bind:key="cxResultat.id" :value="cxResultat.id">{{ cxResultat.nom }}
                </option>
            </select>
          <div class="w-36"></div>
        </div>
    </form>
  <div class="w-full my-12 text-center  text-sm font-bold">
    <!-- Stat domicile -->
    <div class="flex">
        <div class="w-1/2">
            <h5>Domicile :</h5>
            <!-- {{ stats.cptDomicile1 ?? 1}} matchs -->
        </div>
        <div class="w-1/2 text-left">
            <div>Victoire : {{ stats.PVictoireDomicile ?? 1 }}%</div>
            <div>Nul : {{ stats.PNullDomicile ?? 1 }}%</div>
            <div>Défaite : {{ stats.PDefaiteDomicile ?? 1 }}%</div>
        </div>
    </div>
    <div class="my-4">Sur {{ stats.cptDomicile1 ?? 1}} matchs à domicile :
        {{ stats.nbVictoireDomicile ?? 1 }} victoires,
        {{ stats.nbDefaiteDomicile ?? 1}} défaites,
        {{ stats.nbNullDomicile ?? 1}} nuls
    </div>
    <!-- Stat exterieur -->
    <div class="flex mt-4">
        <div class="w-1/2">
            <h5>Exterieur :</h5>
            <!-- {{ stats.cptExterieur1 ?? 1}} matchs -->
        </div>
        <div class="w-1/2 text-left">
            <div>Victoire : {{ stats.PVictoireExterieur ?? 1 }}%</div>
            <div>Nul : {{ stats.PNullExterieur ?? 1 }}%</div>
            <div>Défaite : {{ stats.PDefaiteExterieur ?? 1 }}%</div>
        </div>
    </div>
    <div class="my-4">Sur {{ stats.cptExterieur1 ?? 1}} matchs à l'extérieur :
        {{ stats.nbVictoireExterieur ?? 1 }} victoires,
        {{ stats.nbDefaiteExterieur ?? 1}} défaites,
        {{ stats.nbNullExterieur ?? 1}} nuls
    </div>
</div>
        <!-- Affichage des matchs -->
        <div v-for="listeMatch in listeMatchs" v-bind:key="listeMatch.id" class="flex w-full flex-wrap justify-center content-center items-center text-sm">
            <div class="h-10 w-1/6">{{ listeMatch.date_match  }}</div>
            <div class="h-10 w-1/4" :class="listeMatch.equipes1_id == fields.equipesId ? getCalculResultat(listeMatch.score, true) : '' ">{{ listeMatch.equipe1Nom }}</div>
            <div class="h-10 w-1/6 font-bold">{{ listeMatch.score }}</div>
            <div class="h-10 w-1/4" :class="listeMatch.equipes2_id == fields.equipesId ? getCalculResultat(listeMatch.score, false) : ''">{{ listeMatch.equipe2Nom }}</div>
            <div class="h-10 w-1/12"><img class="h-6 w-auto" :src="listeMatch.equipes1_id == fields.equipesId ? '/images/' + getCalculResultat(listeMatch.score, true) + '.png' : '/images/' + getCalculResultat(listeMatch.score, false) + '.png' " alt="image resultat" :title="listeMatch.commentaire"></div>
            <!-- <div class="h-10 w-1/12"><img class="h-6 w-auto" :src="'/images/victoire.png'" alt="image resultat"></div> -->
        </div>
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
      cxResultats: [
        { id: 1, nom: 'Tous les matchs' },
        { id: 2, nom: 'Domicile' },
        { id: 3, nom: 'Extérieur' },
        { id: 4, nom: 'Prochains matchs' }
      ],
      fields: { seasons_id: 3, championnats_id: 1, equipesId: 1, cxResultats_id: 1 },
      stats: [],
      listeMatchs: [],
      ccResultat: 'defaite'
    }
  },
  mounted () {
    this.getSeason()
    this.getChampionnats()
    this.getEquipes()
    this.getStats()
    this.getResultats()
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

    // recuperation des statistiques
    getStats () {
      axios.get('/api/statistiqueEquipes')
        .then((response) => (this.stats = response.data))
        .catch(err => console.log(err))
    },

    submit () {
      // Liste des équipes par saison et championnat
      axios.post('/api/historiqueEquipes', this.fields)
        .then((response) => (this.equipes = response.data))
        .catch(err => console.log(err))
      // maj liste des matchs
      this.fields.cxResultats_id = 1
      axios.post('/api/listeMatchs', this.fields)
        .then((response) => (this.listeMatchs = response.data))
        .catch(err => console.log(err))
      // recuperation des statistiques
      axios.post('/api/statistiqueEquipes', this.fields)
        .then((response) => (this.stats = response.data))
        .catch(err => console.log(err))
    },

    getResultats () {
      axios.post('/api/listeMatchs', this.fields)
        .then((response) => (this.listeMatchs = response.data))
        .catch(err => console.log(err))
    },

    submitResultat () {
      axios.post('/api/listeMatchs', this.fields)
        .then((response) => (this.listeMatchs = response.data))
        .catch(err => console.log(err))
    },

    // Calcule la couleur du texte à afficher suivant victoire / defaite / null / bientot
    getCalculResultat (leScore, maison) {
      this.pos = leScore.indexOf('-')
      this.scr1 = parseInt(leScore.substring(0, this.pos))
      this.pos++
      this.scr2 = parseInt(leScore.substring(this.pos))

      if (leScore === '-') {
        return 'bientot'
      }
      if (this.scr1 === this.scr2) {
        return 'null'
      }
      if (maison === true) {
        if (this.scr1 > this.scr2) {
          return 'victoire'
        } else {
          return 'defaite'
        }
      }
      if (maison === false) {
        if (this.scr1 > this.scr2) {
          return 'defaite'
        } else {
          return 'victoire'
        }
      }
      return 'probleme'
    }
  }
}
</script>

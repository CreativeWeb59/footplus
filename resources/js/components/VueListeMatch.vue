<template class="relative">
      <!-- Fenetre modale saisie du score Debut -->
        <div v-if="modalVisible" @close="modalVisible = false" class="w-full h-full bg-none absolute top-1/2">
          <div class="mx-auto w-1/4 h-80 bg-red-700 shadow-lg shadow-red-500/50 rounded-xl p-1 pt-2 pr-2">
            <button @click="modalVisible = false" class="text-right text-xl w-full">
            <i class="far fa-window-close"></i>
            </button>
            <h3 class="text-center text-xl -mt-2 text-white">{{ modalData.equipe1Nom }} contre {{ modalData.equipe2Nom }}</h3>
              <form @submit.prevent="submitScore(modalData.id)" class="w-full">
              <div class="class flex justify-center space-x-4 my-2">
                <input type="text" v-model.number="fields.equipe1Score" name="equipe1Score" class="h-8 w-12" ref="equipe1Nom" required minlength="1" maxlength="3" pattern="^([0-9]|1[0-9]|20)$">
                <input type="text" v-model.number="fields.equipe2Score" name="equipe2Score" class="h-8 w-12" required minlength="1" maxlength="3" pattern="^([0-9]|1[0-9]|20)$">
              </div>
              <div class="w-full px-4">
                <textarea v-model="fields.commentaire" name="commentaire" id="" cols="30" rows="10"></textarea>
              </div>
                <div class="class flex justify-center space-x-4">
                  <button type="submit" class="h-8 bg-white rounded-md p-2 pt-1 shadow-md">Valider</button>
                  <button @click="modalVisible = false" class="h-8 bg-white rounded-md p-2 pt-1 shadow-md">Annuler</button>
              </div>
              </form>
          </div>
        </div>
      <!-- Fenetre modale saisie du score Fin -->
            <!-- Fenetre modale commentaire Debut -->
        <div v-if="modalCommentaireVisible" @close="modalCommentaireVisible = false" class="w-full h-full bg-none absolute top-1/2">
          <div class="mx-auto w-1/4 h-80 bg-red-700 shadow-lg shadow-red-500/50 rounded-xl p-1 pt-2 pr-2">
            <button @click="modalCommentaireVisible = false" class="text-right text-xl w-full">
            <i class="far fa-window-close"></i>
            </button>
            <h3 class="text-center text-xl -mt-2 my-4 text-white">{{ modalDataCom.equipe1Nom }} contre {{ modalDataCom.equipe2Nom }}</h3>
              <form @submit.prevent="submitCom(modalDataCom.id, modalDataCom.commentaire)" class="w-full">
              <div class="w-full px-4">
                <textarea v-model="modalDataCom.commentaire" ref="commentaire" name="commentaire" id="" cols="30" rows="20"></textarea>
              </div>
                <div class="class flex justify-center space-x-4 mt-4">
                  <button type="submit" class="h-8 bg-white rounded-md p-2 pt-1 shadow-md">Valider</button>
                  <button @click="modalCommentaireVisible = false" class="h-8 bg-white rounded-md p-2 pt-1 shadow-md">Annuler</button>
              </div>
              </form>
          </div>
        </div>
      <!-- Fenetre modale commentaire Fin -->
<div class="w-full my-8 flex flex-col justify-center content-center items-center">
    <form @submit.prevent="submit" class="mt-8 w-full p-2">
        <div class="w-full mb-8 flex justify-center space-x-12 items-center content-center">
          <label class="entete" for="championnat_id">Championnat : </label>
          <select name="championnat_id" id="championnat_id" v-model="fields.championnats_id" @change="submit">
            <option v-for="championnat in championnats" v-bind:key="championnat.id" :value="championnat.id">{{ championnat.nom }}
            </option>
          </select>
          <label class="entete pl-1" for="season_id">Saison : </label>
          <select name="season_id" id="season_id" v-model="fields.seasons_id" @change="submit">
              <option v-for="season in seasons" v-bind:key="season.id" :value="season.id">{{ season.nom }}
              </option>
          </select>
        </div>
        <div class="w-full my-8 flex justify-center">
          <button class="mr-4" name="moins" title="Moins" v-show="fields.cx_journee > 1">
            <img class="h-10 w-auto" :src="'/images/fleche_gauche2.png'" alt="moins" @click="moveCalendrier('moins')">
          </button>
            <button class="mr-4 opacity-0 pointer-events-none" name="noneM" title="noneM" v-show="fields.cx_journee === 1">
            <img class="h-10 w-auto" :src="'/images/fleche_gauche2.png'" alt="noneM">
          </button>
          <span class="id-form-img1">
          <select class="mx-auto" name="cx_journee" id="cx_journee" v-model="fields.cx_journee" @change="submit">
            <option v-for="cx_journee in nbJournees" v-bind:key="cx_journee" :value="cx_journee">{{ cx_journee == 1 ? cx_journee+'re' : cx_journee+'ème'  }} journée
            </option>
          </select>
          </span>
           <button class="ml-4" name="plus" v-if="fields.cx_journee < 38">
              <img class="h-10 w-auto" :src="'./images/fleche_droite2.png'" alt="plus" title="Plus" @click="moveCalendrier('plus')">
          </button>
            <button class="mr-4 opacity-0 pointer-events-none" name="noneP" title="noneP" v-show="fields.cx_journee === nbJournees">
              <img class="h-10 w-auto" :src="'/images/fleche_droite2.png'" alt="noneP">
          </button>
        </div>
    </form>
    <div v-for="calendrier in calendriers" v-bind:key="calendrier.id" class="w-full text-lg font-bold my-2">
    <form @submit.prevent="editCalendrier" class="w-full flex flex-wrap justify-center content-center items-center space-x-8">
      <div class="w-48 h-8 entete">{{ calendrier.date_match != dateEnCours ? calendrier.date_match : 0}}</div>
      <div class="w-72 h-8 bg-white border shadow-xl text-center">{{ calendrier.equipe1Nom }}</div>
      <div class="w-12"><img class='img-logo h-10 w-auto' alt="logo_equipe1" :src="'/images/'+calendrier.equipe1Logo+'.png'"/></div>
      <div v-if="calendrier.score == '-'" class="h-8 text-white w-32 border shadow-xl text-center rounded" :class="[calendrier.score == '-' ? 'bg-white text-slate-900' : 'bg-slate-900']"
              @click="openModal([{ equipe1Nom:calendrier.equipe1Nom, equipe2Nom:calendrier.equipe2Nom, id:calendrier.id }])"
              >{{ calendrier.score == '-' ? calendrier.heure_match : calendrier.score }}
      </div>
      <div v-else class="h-8 w-32 flex justify-center content-center items-center">
          <input type="text" id="buts_equipe1" name="calendrierEquipe1Score" v-model="calendrier.calendrierEquipe1Score" @change="majScore(calendrier.id, calendrier.calendrierEquipe1Score, calendrier.calendrierEquipe2Score)" class="w-12 h-8 text-white bg-slate-900 border shadow-xl text-center rounded" minlength="1" maxlength="3" pattern="^([0-9]|1[0-9]|20)$">
          <span class="mx-2 text-2xl">-</span>
          <input type="text" id="buts_equipe1" name="calendrierEquipe2Score" v-model="calendrier.calendrierEquipe2Score" @change="majScore(calendrier.id, calendrier.calendrierEquipe1Score, calendrier.calendrierEquipe2Score)" class="w-12 h-8 text-white bg-slate-900 border shadow-xl text-center rounded" minlength="1" maxlength="3" pattern="^([0-9]|1[0-9]|20)$">
      </div>
      <div class="w-12"><img class='img-logo h-10 w-auto' alt="logo_equipe1" :src="'/images/'+calendrier.equipe2Logo+'.png'"/></div>
      <div class="w-72 h-8 bg-white border shadow-xl text-center">{{ calendrier.equipe2Nom }}</div>
      <div class="w-48 cursor-pointer" @click="openModalCom([{ equipe1Nom:calendrier.equipe1Nom, equipe2Nom:calendrier.equipe2Nom, commentaire:calendrier.commentaire, id:calendrier.id }])"><img class="w-auto h-8" :src="'/images/ballon.png'" alt="noneM" title="Voir / modifier le commentaire"></div>
    </form>
</div>
</div>

</template>

<script>
import axios from 'axios'
// import { required, minLength } from 'vuelidate/lib/validators'

export default {
  data () {
    return {
      modalVisible: false,
      modalData: null,
      modalCommentaireVisible: false,
      modalDataCom: null,
      nbJournees: 0,
      championnat_id: 0,
      seasons_id: 0,
      dateEnCours: 0,
      equipeScore: 0,
      commentaire: '',
      cx_journee: [],
      calendriers: [],
      seasons: [],
      championnats: [],
      fields: { cx_journee: 1, seasons_id: 3, championnats_id: 1, equipe1Score: 0, equipe2Score: 0, id: 0, calendrierEquipe1Score: 0, calendrierEquipe2Score: 0, commentaire: '' }
    }
  },
  mounted () {
    this.getNbJournees()
    this.getSeason()
    this.getChampionnats()
  },
  validations: {
    form: {
      // name: { required, min: minLength(10) }
    }
  },
  methods: {
    getNbJournees () {
      axios.get('/api/calendrier')
        .then((response) => {
          this.nbJournees = response.data.nbJournees
          this.calendriers = response.data.calendriers
        })
        .catch(err => console.log(err))
    },

    submit () {
      axios.post('/api/calendrier', this.fields)
        .then((response) => {
          this.nbJournees = response.data.nbJournees
          this.calendriers = response.data.calendriers
        })
        .catch(err => console.log(err))
    },
    moveCalendrier (moveTo) {
      if (moveTo === 'plus') {
        this.fields.cx_journee++
      } else {
        this.fields.cx_journee--
      }
      axios.post('/api/calendrier', this.fields)
        .then((response) => {
          this.nbJournees = response.data.nbJournees
          this.calendriers = response.data.calendriers
        })
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
    openModal (data) {
      this.modalData = data[0]
      this.modalVisible = true
      this.$nextTick(function () {
        this.$refs.equipe1Nom.focus()
        // this.$refs.search[0].focus()
      })
    },
    openModalCom (data) {
      this.modalDataCom = data[0]
      // console.log('test ' + this.modalDataComdata.commentaire)
      this.modalCommentaireVisible = true
      this.$nextTick(function () {
        this.$refs.commentaire.focus()
      })
    },
    submitScore (id) {
      this.fields.id = id
      // mise a jour du match
      axios.put('/api/calendrier', this.fields)
        .then((response) => {
          this.nbJournees = response.data.nbJournees
          this.calendriers = response.data.calendriers
        })
        .catch(err => console.log(err))
      // fermeture du modal
      this.modalVisible = false
      // raz de la fenetre
      this.fields.equipe1Score = 0
      this.fields.equipe2Score = 0
      this.fields.commentaire = ''
    },
    submitCom (id, commentaire) {
      this.fields.id = id
      this.fields.commentaire = commentaire
      // mise a jour du match
      console.log('commentaire : ' + commentaire)
      axios.patch('/api/calendrierCom', this.fields)
        .then((response) => {
          this.nbJournees = response.data.nbJournees
          this.calendriers = response.data.calendriers
        })
        .catch(err => console.log(err))
      // fermeture du modal
      this.modalCommentaireVisible = false
      // raz de la fenetre
      this.fields.commentaire = ''
    },
    majScore (id, equipe1Score, equipe2Score) {
      this.fields.id = id
      this.fields.equipe1Score = equipe1Score
      this.fields.equipe2Score = equipe2Score
      // mise a jour du match
      axios.patch('/api/calendrier', this.fields)
        .then((response) => {
          this.nbJournees = response.data.nbJournees
          this.calendriers = response.data.calendriers
        })
        .catch(err => console.log(err))
    }
  }
}
</script>

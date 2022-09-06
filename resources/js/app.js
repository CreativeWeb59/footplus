import './bootstrap'
import Alpine from 'alpinejs'
// import AddToCart from './components/AddToCart.vue'
import VueClassement from './components/VueClassement.vue'
import VueListeMatch from './components/VueListeMatch.vue'
import VueStatistiques from './components/VueStatistiques.vue'
import VueJournees from './components/VueJournees.vue'
import VueSelect from './components/VueSelect.vue'
import MoveDiv from './components/MoveDiv.vue'

import { createApp } from 'vue/dist/vue.esm-bundler'

window.Alpine = Alpine
Alpine.start()

const app = createApp({})

// app.component('AddToCart', AddToCart)
app.component('vue-classement', VueClassement)
app.component('vue-liste-match', VueListeMatch)
app.component('vue-statistiques', VueStatistiques)
app.component('vue-journees', VueJournees)
app.component('vue-select', VueSelect)
app.component('move-div', MoveDiv)

app.mount('#app')

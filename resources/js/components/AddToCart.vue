<template>
        <button class="bg-indigo-500 text-white p-2 w-3/4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
            v-on:click.prevent="VueClassement"
            >Cliquez
        </button>
</template>

<script setup>
import axios from 'axios'
import useEquipe from '../composables/equipes'

const { add } = useEquipe()
const equipeId = defineProps(['equipeId'])

const addToCart = async () => {
  await axios.get('/sanctum/csrf-cookie')
  await axios.get('/api/user')
    .then(async (res) => {
      await add(equipeId)
    })
    .catch(err => console.log(err))
}
</script>

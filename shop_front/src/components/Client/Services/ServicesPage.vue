<script>
import axios from "axios";

export default {
  data() {
    return {
      services: ''
    }
  },
  methods: {
    getServices() {
      axios.get('http://localhost:8000/api/services', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(response => {
                console.log(response)
                this.services = response.data
              })
          .catch(error => {
      if (error.response.data.message === 'Token has expired') {
        this.$router.push('/login')
      } else {
        console.log(error);
        }
      })
    }
  },
  mounted() {
    this.getServices()
  }
}
</script>

<template>
  <div class="container mx-auto mt-5">
    <h2 class="text-center text-2xl font-bold mb-4">Список услуг</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="service in services" :key="service.id" class="bg-white shadow-lg rounded-lg overflow-hidden">
        <img :src="service.image" :alt="service.name" class="w-full h-48 object-cover"/>
        <div class="p-4 text-center">
          <h5 class="text-lg font-semibold">{{ service.name }}</h5>
          <p class="text-gray-600">Цена: {{ service.price }} ₸</p>
          <router-link :to="`/service/${service.id}`" href="#" class="mt-2 inline-block text-blue-500">Подробнее</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Применение стилевых классов Tailwind, дополнительных стилей не требуется */
</style>




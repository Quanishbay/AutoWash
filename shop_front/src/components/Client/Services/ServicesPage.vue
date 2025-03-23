<script>
import axios from "axios";
import WashMap from "@/components/Map/WashMap.vue";

export default {
  components: {
    WashMap
  },
  data() {
    return {
      services: [],
      selectedService: null, // Храним выбранную услугу
      carWashes: [] // Список автомоек
    }
  },
  methods: {
    async getServices() {
      try {
        const response = await axios.get('http://localhost:8000/api/services', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`
          }
        });
        this.services = response.data;
      } catch (error) {
        if (error.response?.data?.message === 'Token has expired') {
          this.$router.push('/login');
        } else {
          console.error(error);
        }
      }
    },
    async getCarWashes() {
      if (!this.selectedService) return;

      try {
        const response = await axios.get(`http://localhost:8000/api/carwashes?service_id=${this.selectedService.id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`
          }
        });
        this.carWashes = response.data; // Обновляем точки автомоек
      } catch (error) {
        console.error(error);
      }
    }
  },
  watch: {
    selectedService() {
      this.getCarWashes(); // При изменении услуги обновляем карту
    }
  },
  mounted() {
    this.getServices();
  }
}
</script>

<template>
  <div class="container mx-auto mt-5">
    <h2 class="text-center text-2xl font-bold mb-4">Список услуг</h2>

    <!-- Выпадающий список для выбора услуги -->
    <div class="mb-4 text-center">
      <label for="service" class="block text-lg font-semibold mb-2">Выберите услугу:</label>
      <select id="service" v-model="selectedService" class="p-2 border rounded" @change="getCarWashes">
        <option v-for="service in services" :key="service.id" :value="service">
          {{ service.name }}
        </option>
      </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="service in services" :key="service.id" class="bg-white shadow-lg rounded-lg overflow-hidden">
        <img :src="service.image" :alt="service.name" class="w-full h-48 object-cover"/>
        <div class="p-4 text-center">
          <h5 class="text-lg font-semibold">{{ service.name }}</h5>
          <p class="text-gray-600">Цена: {{ service.price }} ₸</p>
          <router-link :to="`/service/${service.id}`" class="mt-2 inline-block text-blue-500">Подробнее</router-link>
        </div>
      </div>
    </div>
  </div>

  <!-- Передаём выбранную услугу и автомойки в карту -->
  <WashMap :carWashes="carWashes"></WashMap>
</template>

<style scoped>
/* Стилей не нужно, так как Tailwind уже делает всё красиво */
</style>

<template>
  <div class="container mx-auto mt-10">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
      <img :src="service.image" :alt="service.name" class="w-full h-64 object-cover rounded">
      <h1 class="text-3xl font-bold mt-4">{{ service.name }}</h1>
      <p class="text-gray-600 mt-2">{{ service.description }}</p>
      <p class="text-xl font-semibold mt-4">{{ service.price }} ₽</p>
      <input v-model.number="quantity" type="number" min="1" class="mt-4 p-2 border rounded">
      <button @click="storeItem" class="mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded">Add to cart</button>
      <router-link to="/" class="ml-5 mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded">Назад</router-link>
    </div>
    <CategoryPage :storeItem="storeItem"/>
  </div>
</template>

<script>
import axios from 'axios';
import CategoryPage from "@/components/Client/Category/CategoryShow.vue";

export default {
  components: {CategoryPage},
  props: ['id'],
  data() {
    return {
      quantity: 1,
      price: 0,
      service: {}
    };
  },
  methods: {
    getServiceDetails() {
      axios.get(`http://localhost:8000/api/services/${this.id}`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(response => {
            this.service = response.data;
            this.price = this.service.price;
          })
          .catch(error => {
            console.log('Error: ', error.response.data);
            if (error.response?.data?.message === 'Token has expired') {
              this.$router.push('/login')
              localStorage.removeItem('access_token');
              localStorage.removeItem('role');
            }
            console.error('Second Error: ', error);
          });
    },
    storeItem(categoryId) {
      axios.post('http://localhost:8000/api/carts', {
            'service_id': this.id,
            'quantity': this.quantity,
            'total': this.price * this.quantity,
            'status': 'active',
            'category_id': categoryId
          },
      )
          .then(() => {
            alert('The service was successful created')
            this.quantity = 1
          })
    }
  },
  mounted() {
    this.getServiceDetails();
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
}
</style>

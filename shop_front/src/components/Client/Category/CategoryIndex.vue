<template>
  <div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="category in categories" :key="category.id" @click="goToCategory(category.id)"
           class="bg-white shadow-lg rounded-lg p-6 cursor-pointer hover:shadow-xl transition-shadow duration-300">
        <h3 class="text-xl font-semibold text-gray-900 hover:text-blue-500">{{ category.name }}</h3>
        <h2 class="text-gray-700 mt-2">{{ category.description }}</h2>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data(){
    return{
      categories : null
    }
  },
  methods:{
    getCategories(){
      axios.get('http://localhost:8000/api/categories', {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then((response => {
            this.categories = response.data
          }))
    },

    goToCategory(id) {
      this.$router.push({ path: `/category/${id}`})
    }
  },
  mounted() {
    this.getCategories()
  }
}
</script>

<style scoped>
h3 {
  color: #000000;
  cursor: pointer;
  text-decoration: underline;
  transition: color 0.3s ease-in-out;
}

h3:hover {
  color: #007bff;
}

h2 {
  color: #533838;
}
</style>

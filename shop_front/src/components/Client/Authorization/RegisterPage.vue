<script>
import axios from "axios";

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }
  },
  methods: {
    register() {
      axios.post('http://localhost:8000/api/user/register', {
        'name': this.name,
        'email': this.email,
        'password': this.password,
        'password_confirmation': this.password_confirmation
      })
          .then((response) => {
            console.log(response);
            localStorage.setItem('access_token', response.data.access_token)
            this.$router.push('/home')
          })
    }
  }
}
</script>

<template>
  <div class="max-w-sm mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

    <div class="space-y-4">
      <!-- Поле для имени -->
      <input
          v-model="name"
          type="text"
          placeholder="Name"
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
      />

      <!-- Поле для email -->
      <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
      />

      <!-- Поле для пароля -->
      <input
          v-model="password"
          type="password"
          placeholder="Password"
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
      />

      <!-- Поле для подтверждения пароля -->
      <input
          v-model="password_confirmation"
          type="password"
          placeholder="Confirm Password"
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
      />

      <!-- Кнопка регистрации -->
      <button
          @click="register"
          class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        Register
      </button>

      <!-- Сообщение о несовпадении паролей -->
      <p v-if="password && password_confirmation && password !== password_confirmation" class="text-red-500 text-sm mt-2">
        Passwords do not match.
      </p>
    </div>
  </div>
</template>

<style scoped>

</style>
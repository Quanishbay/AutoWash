<template>
  <div class="max-w-sm mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    <div class="space-y-4">
      <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
      />
      <input
          v-model="password"
          type="password"
          placeholder="Password"
          class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
      />
      <button
          @click="login"
          class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        Login
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async login() {
      try {
        console.log("Отправка запроса на логин...");
        const response = await axios.post("http://localhost:8000/api/auth/login", {
          email: this.email,
          password: this.password,
        });

        console.log("Ответ от сервера:", response.data);

        if (!response.data.access_token) {
          throw new Error("Токен не получен!");
        }

        localStorage.setItem("access_token", response.data.access_token);
        await this.check_admin();
        this.$router.push("/categories");
        setTimeout(() => {
          window.location.reload();
        }, 200);
      } catch (error) {
        console.error("Ошибка авторизации:", error.response?.data || error.message);
      }
    },

    async check_admin() {
      try {
        console.log("Проверка роли пользователя...");
        const response = await axios.post(
            "http://localhost:8000/api/auth/me",
            {},
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("access_token")}`,
              },
            }
        );

        console.log("Данные пользователя:", response.data);

        if (!response.data.role) {
          throw new Error("Роль пользователя не получена!");
        }

        localStorage.setItem("role", response.data.role);
      } catch (error) {
        console.error("Ошибка проверки роли:", error.response?.data || error.message);
      }
    },
  },
};
</script>

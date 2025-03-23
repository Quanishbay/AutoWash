<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-50">
    <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
      <!-- Левая часть: Информация о пользователе -->
      <div class="bg-beige-100 p-8 flex flex-col items-center">
        <div class="w-32 h-32 rounded-full overflow-hidden">
          <img src="https://via.placeholder.com/150" alt="Profile Picture" />
        </div>
        <h2 v-if="userData" class="mt-4 text-xl font-semibold">{{ userData.name }}</h2>
        <p v-if="userData" class="text-gray-600">{{ userData.email }}</p>
        <p v-if="userData" class="text-gray-600">Role: {{ userData.role }}</p>

        <div class="flex mt-4 space-x-4">
          <a href="#" class="text-gray-600 hover:text-blue-500"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-gray-600 hover:text-blue-500"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-gray-600 hover:text-blue-500"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="text-gray-600 hover:text-blue-500"><i class="fab fa-instagram"></i></a>
        </div>

        <button v-if="userData" @click="history(userData.id)" class="mt-4 history-button">Purchases History</button>
      </div>

      <!-- Правая часть: История покупок -->
      <div class="p-8 flex-1">
        <h1 class="text-4xl font-bold">Hello</h1>
        <p class="mt-2 text-gray-600">Here's who I am & what I do</p>

        <p v-if="!historyData" class="mt-6 text-gray-600">
          I'm a paragraph. Click here to add your own text and edit me. It's easy.
        </p>

        <div v-if="historyData" class="history-table-container">
          <table class="history-table">
            <thead>
            <tr>
              <th>Number</th>
              <th>Quantity</th>
              <th>Service Name</th>
              <th>Status</th>
              <th>Create Time</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(data, index) in historyData" :key="data.id">
              <td>{{ index + 1 }}</td>
              <td>{{ data.quantity }}</td>
              <td>{{ data.service.name }}</td>
              <td>{{ data.status }}</td>
              <td>{{ new Date(data.created_at).toLocaleString() }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      userData: "",
      historyData: "",
    };
  },
  methods: {
    getInfo() {
      axios
          .post(
              "http://localhost:8000/api/auth/me",
              {},
              {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem("access_token")}`,
                },
              }
          )
          .then((response) => {
            this.userData = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
    },
    history(id) {
      axios
          .get(`http://localhost:8000/api/history/${id}`, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("access_token")}`,
            },
          })
          .then((response) => {
            this.historyData = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
    },
  },
  mounted() {
    this.getInfo();
  },
};
</script>

<style scoped>
/* Добавим цвета для фона и стили кнопок */
.bg-beige-100 {
  background-color: #f5ede6;
}

.user-info {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.history-button {
  background-color: #ff9f00;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.history-button:hover {
  background-color: #e68900;
}

.history-table-container {
  overflow-x: auto;
}

.history-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.history-table th,
.history-table td {
  padding: 12px 15px;
  text-align: left;
}

.history-table thead {
  background-color: #f1f1f1;
}

.history-table th {
  font-weight: bold;
  color: #444;
}

.history-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.history-table tr:hover {
  background-color: #f2f2f2;
}

.history-table td {
  border-bottom: 1px solid #ddd;
}
</style>

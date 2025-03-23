<template>
  <div class="flex space-x-6">
    <router-link v-if="!isAuthenticated" to="/login" class="nav-link">Login</router-link>
    <router-link v-if="!isAuthenticated" to="/register" class="nav-link">Register</router-link>
    <router-link v-if="isAuthenticated" to="/cart" class="nav-link">Cart</router-link>
    <router-link v-if="isAdmin" to="/edit/categories" class="nav-link">Edit Categories</router-link>
    <button v-if="isAuthenticated" @click="logout" class="nav-link">Logout</button>
    <button v-if="userData" @click="profilePage(userData.id)" class="nav-link">
      {{ userData.name }}
    </button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      userData: null
    };
  },
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem("access_token");
    },
    isAdmin() {
      return localStorage.getItem("role") === "admin";
    }
  },
  methods: {
    async getProfile() {
      try {
        const response = await axios.post(
            "http://localhost:8000/api/auth/me",
            {},
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("access_token")}`
              }
            }
        );
        this.userData = response.data;
      } catch (error) {
        console.error("Ошибка загрузки профиля:", error);
      }
    },
    logout() {
      localStorage.removeItem("access_token");
      localStorage.removeItem("role");
      this.userData = null;
      this.$router.push("/login");
    },
    profilePage(id) {
      this.$router.push(`/profile/${id}`);
    }
  },
  watch: {
    isAuthenticated(newVal) {
      if (newVal) {
        this.getProfile();
      } else {
        this.userData = null;
      }
    }
  },
  mounted() {
    if (this.isAuthenticated) {
      this.getProfile();
    }
  }
};
</script>

<style scoped>
.nav-link {
  font-size: 1rem;
  font-weight: 500;
  color: #007bff;
  text-decoration: none;
  transition: color 0.3s ease-in-out;
}

.nav-link:hover {
  color: #0056b3;
}
</style>

<template>
  <nav class="flex items-center justify-between py-4 border-b border-gray-300 bg-white shadow-md px-6 rounded-lg">
    <div class="flex space-x-6">
      <router-link to="/home" class="nav-link">Home</router-link>
      <router-link to="/about" class="nav-link">About us</router-link>
      <router-link to="/contacts" class="nav-link">Contacts</router-link>
    </div>
    <AuthButtons />
  </nav>
</template>

<script>

import AuthButtons from "@/components/Client/Authorization/AuthButtons.vue";

export default {
  components: {
    AuthButtons
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

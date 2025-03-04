<script>
export default {
  computed:{
    isAuthenticated() {
      return !! localStorage.getItem('access_token')
    }
  },
      methods: {
        logout() {
          localStorage.removeItem('access_token')
          localStorage.removeItem('role')
          this.$router.push('/login')
        }
      }
}
</script>

<template>
  <button v-if="isAuthenticated" @click="logout()"></button>
</template>

<style scoped>

</style>
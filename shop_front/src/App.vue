<template>
  <div class="container mx-auto px-4 py-2">
    <NavigationBar />
    <router-view></router-view>
  </div>
</template>

<script>

import NavigationBar from "@/components/Navigation/NavigationBar.vue";

export default {
  components: {
    NavigationBar,
  }
};
</script>

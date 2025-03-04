<template>
  <div class="container mx-auto px-4 py-2">
    <NavigationBar />
    <router-view></router-view>
    <WashMap />
  </div>
</template>

<script>

import NavigationBar from "@/components/Navigation/NavigationBar.vue";
import WashMap from "@/components/Map/WashMap.vue";

export default {
  components: {
    NavigationBar,
    WashMap
  }
};
</script>
